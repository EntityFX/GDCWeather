<?php

namespace app\utils\workers\contracts;

use app\utils\Limit;

interface WorkerManagerInterface {

    const FAULT_WORKER_DOESNT_EXIST = 1;

    const FAULT_WORKER_ALREADY_RUNNING = 2;

    const FAULT_WORKER_IS_NOT_RUNNING = 3;

    function getWorkerInfoList(Limit $limit);

    function getWorker($workerId);

    function countWorkers();

    function runWorker($workerId);

    function releaseWorker($workerId);
}