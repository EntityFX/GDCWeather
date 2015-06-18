<?php

namespace app\utils\workers\repositories;

use app\utils\Limit;

interface WorkerRepositoryInterface {
    /**
     * @param int $workerId
     *
     * @return WorkerData
     */
    public function getWorker($workerId);

    /**
     * @param Limit $limit
     *
     * @return WorkerData
     */
    public function getWorkerList(Limit $limit);

    public function updateWorkerStatus(WorkerData $worker);

    /**
     * @param $workerId
     *
     * @return int[]|array
     */
    public function getWorkerWebClientIdList($workerId);

    public function count();
}