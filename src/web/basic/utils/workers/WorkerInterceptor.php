<?php

namespace app\utils\workers;

use app\utils\exceptions\InternalExceptionBase;
use app\utils\exceptions\WorkerException;
use app\utils\workers\repositories\WorkerData;
use app\utils\workers\repositories\WorkerRepositoryInterface;
use app\utils\workers\repositories\WorkerStatusEnum;
use DateTime;
use yii\base\Component;
use yii\base\Event;
use yii\base\Exception;
use yii\log\Logger;

class WorkerInterfaceInterceptor extends Component implements WorkerInterface, WorkerInterceptorInterface {

    /**
     * @var WorkerInterface
     */
    private $_worker;

    /**
     * @var WorkerRepositoryInterface
     */
    private $_workerRepository;

    public function __construct(WorkerInterface $worker, WorkerRepositoryInterface $workerRepository) {
        $this->_worker = $worker;
        $this->_workerRepository = $workerRepository;
        $this-> registerErrorHandlers();
    }

    public function onBeginRun(array $args = null) {
        $workerData = new WorkerData();
        $workerData->id = $this->_worker->getId();
        $workerData->status = new WorkerStatusEnum(WorkerStatusEnum::IN_PROGRESS);
        $workerData->pid = getmypid();
        $workerData->startDateTime = new DateTime();
        $this->_workerRepository->updateWorkerStatus($workerData);

        $this->log("worker {$workerData->id} started, Pid: {$workerData->pid}", Logger::LEVEL_INFO);

        $event = new Event($this, array('args' => $args));
        $this->raiseEvent(self::EVENT_ON_BEGIN_RUN, $event);
        return $this->_worker->onBeginRun($args);
    }

    public function onEndRun() {
        $workerData = new WorkerData();
        $workerData->id = $this->_worker->getId();
        $workerData->status = new WorkerStatusEnum(WorkerStatusEnum::ACTIVE);
        $workerData->endDateTime = new DateTime();
        $this->_workerRepository->updateWorkerStatus($workerData);

        $event = new Event($this);
        $this->raiseEvent(self::EVENT_ON_END_RUN, $event);
        $this->log("worker {$workerData->id} ended", Logger::LEVEL_INFO);
        $this->_worker->onEndRun();
    }

    public function onFailed(WorkerException $exception) {
        $this->handleException($exception);
        $this->_worker->onFailed($exception);
    }

    public function run(array $args = null) {
        try {

            if ($this->onBeginRun($args)) {
                $this->processRun($args);
                $this->onEndRun();
            }
        } catch(Exception $exception) {
            $workerException = new WorkerException('Error in worker', null, $exception);
            $this->onFailed($workerException);
            throw $workerException;
        }
    }

    /**
     * @return WorkerInterface
     */
    public function getWorker() {
        return $this->_worker;
    }

    public function processRun(array $args = null) {
        $this->_worker->run($args);
    }

    public function getId() {
        return $this->_worker->getId();
    }

    public function getName() {
        return $this->_worker->getName();
    }

    public function getStatus() {
        return $this->_worker->getStatus();
    }

    /**
     * @return WorkerSettings
     */
    public function getWorkerSettings() {
        return $this->_worker->getWorkerSettings();
    }

    public function setWorkerSettings(WorkerSettings $settings) {
        $this->_worker->setWorkerSettings($settings);
    }

    public function log($message, $severity = Logger::LEVEL_INFO) {
        $this->_worker->log($message, $severity);
    }

    private function handleException(WorkerException $exception) {
        $workerData = new WorkerData();
        $workerData->id = $this->_worker->getId();
        $workerData->status = new WorkerStatusEnum(WorkerStatusEnum::FAILED);
        $workerData->endDateTime = new DateTime();
        $this->_workerRepository->updateWorkerStatus($workerData);

        $event = new Event($this);
        $event->params = $exception;
        $this->raiseEvent(self::EVENT_ON_FAILED, $event);
        $message = "worker {$workerData->id} failed, Exception \"{$exception->getMessage()}\"";
        do {
            $internalException = $exception->getInternalException();
            if ($internalException !== null) {
                $message .= ", \t\nInternal exception: \"{$internalException->getMessage()}\" :";
                $message .= "\t\t\n Trace:" . $internalException->getTraceAsString();
            }
            $exception = $internalException;
        } while ($internalException !== null && $internalException instanceof InternalExceptionBase);

        $this->log($message, Logger::LEVEL_ERROR);
    }

    public function shutdownErrorHandler() {
        $error = error_get_last();
        if (isset($error))
            if($error['type'] == E_ERROR
                || $error['type'] == E_PARSE
                || $error['type'] == E_COMPILE_ERROR
                || $error['type'] == E_CORE_ERROR)
            {
                $message = "Error in file {$error['file']} in line {$error['line']}\r\n";
                $message .= $error['message'];

                $this->onFailed(new WorkerException($message));
            }

    }

    public function errorHandler($errno , $errstr, $errfile, $errline) {
        $message = "Error in file {$errfile} in line {$errline}\r\n";
        $message .= $errstr;
        $this->onFailed(new WorkerException($message));
    }

    private function registerErrorHandlers() {
        set_error_handler(array($this, 'errorHandler'));
        register_shutdown_function(array($this, 'shutdownErrorHandler'));
    }
}