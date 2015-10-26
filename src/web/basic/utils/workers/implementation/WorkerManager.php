<?php

namespace app\utils\workers\implementation;

use app\utils\exceptions\ManagerException;
use app\utils\Limit;
use app\utils\ManagerBase;
use app\utils\workers\contracts\repositories\WorkerData;
use app\utils\workers\contracts\repositories\WorkerRepositoryInterface;
use app\utils\workers\contracts\repositories\WorkerStatusEnum;
use app\utils\workers\contracts\WorkerManagerInterface;
use app\utils\workers\WorkerFactory;
use DateTime;

class WorkerManager extends ManagerBase implements WorkerManagerInterface {

    /**
     * @var WorkerRepositoryInterface
     */
    private $_workerRepository;

    public function __construct(WorkerRepositoryInterface $workerRepository) {
        parent::__construct();
        /** @var $workerRepository WorkerRepositoryInterface */
        $this->_workerRepository = $workerRepository;
    }

    function getWorkerInfoList(Limit $limit) {
        return $this->_workerRepository->getWorkerList($limit);
    }

    function countWorkers() {
        return $this->_workerRepository->count();
    }

    function runWorker($workerId) {
        /** @var $worker WorkerData */
        $worker = $this->_workerRepository->getWorker($workerId);
        if ($worker == null) {
            throw new ManagerException("Worker with id {$workerId} does'nt exist", self::SERVICE_CATEGORY, self::FAULT_WORKER_DOESNT_EXIST);
        }

        if ($worker->status->getValue() === WorkerStatusEnum::IN_PROGRESS) {
            throw new ManagerException("Worker with id {$workerId} is already running", self::SERVICE_CATEGORY, self::FAULT_WORKER_ALREADY_RUNNING);
        }
        WorkerFactory::createWorkerAndRun($workerId);
    }

    function releaseWorker($workerId) {
        /** @var $worker WorkerData */
        $worker = $this->_workerRepository->getWorker($workerId);
        if ($worker == null) {
            throw new ManagerException("Worker with id {$workerId} does'nt exist", self::SERVICE_CATEGORY, self::FAULT_WORKER_DOESNT_EXIST);
        }
        if ($worker->status->getValue() !== WorkerStatusEnum::IN_PROGRESS) {
            throw new ManagerException("Worker with is {$workerId} is not running", self::SERVICE_CATEGORY, self::FAULT_WORKER_IS_NOT_RUNNING);
        }
        $workerData = new WorkerData();
        $workerData->id = $workerId;
        $workerData->pid = null;
        $workerData->startDateTime = null;
        $workerData->endDateTime = new DateTime();
        $workerData->status = new WorkerStatusEnum(WorkerStatusEnum::ACTIVE);
        $this->_workerRepository->updateWorkerStatus($workerData);
    }

    function getWorker($workerId) {
        return $this->_workerRepository->getById($workerId);
    }
}