<?php

namespace app\utils\workers\implementation;

use app\utils\workers\contracts\WorkerInterface;
use app\utils\workers\contracts\WorkerSettings;
use yii\base\Component;
use app\utils\workers\contracts\repositories\WorkerStatusEnum;
use Yii;
use app\utils\exceptions\WorkerException;
use yii\log\Logger;

/**
 * Class WorkerBase
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property WorkerSettings $workerSettings
 * @property-read Phemto $ioc
 */
abstract class WorkerBase extends Component implements WorkerInterface {

    /**
     * @var WorkerSettings
     */
    private $_workerSettings;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var int
     */
    private $_id;

    /**
     * @var WorkerStatusEnum
     */
    private $_status;

    public function __construct() {
        parent::__construct();
        //Yii::getLogger()->dispatcher-> = true;
        //Yii::getLogger()->autoFlush=100;
    }

    /**
     * @return Phemto
     */
    protected function getIoc() {
        return Yii::$app->ioc->container;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * @return WorkerSettings
     */
    public function getWorkerSettings() {
        return $this->_workerSettings;
    }

    public function setWorkerSettings(WorkerSettings $settings) {
        $this->_workerSettings = $settings;

        if ($settings->workerData === null) throw new WorkerException("Worker data are empty", self::FAULT_WORKER_DATA_EMPTY);
        $this->_name = $settings->workerData->workerName;
        $this->_id = $settings->workerData->id;
        $this->_status = $settings->workerData->status;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function log($message, $severity = Logger::LEVEL_INFO) {
        Yii::getLogger()->log("Worker #{$this->id}, name \"{$this->name}\": $message", $severity, self::WORKER_CATEGORY);
    }
}