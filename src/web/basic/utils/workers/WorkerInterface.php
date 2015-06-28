<?php

namespace app\utils\workers;

use app\utils\exceptions\WorkerException;

interface WorkerInterface {

    /**
     *
     */
    const FAULT_WORKER_DATA_EMPTY = 1;

    const FAULT_WORKER_DOESNT_EXIST = 2;

    const FAULT_INSTANCE_NOT_FOUND = 3;

    const WORKER_CATEGORY = "application.components.workers";

    public function onBeginRun(array $args = null);

    public function onEndRun();

    public function onFailed(WorkerException $exception);

    /**
     * @param array $args
     *
     */
    public function run(array $args = null);

    public function getId();

    public function getName();

    public function getStatus();

    /**
     * @return WorkerSettings
     */
    public function getWorkerSettings();

    public function setWorkerSettings(WorkerSettings $settings);

    public function log($message, $severity= CLogger::LEVEL_INFO);
}