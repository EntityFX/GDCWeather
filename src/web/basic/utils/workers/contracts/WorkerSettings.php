<?php

namespace app\utils\workers\contracts;
use yii\base\Component;
use app\utils\workers\contracts\repositories\WorkerData;

/**
 * Class WorkerSettings
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property WorkerData $workerData
 */
class WorkerSettings extends Component {
    private $_workerData;

    public function setWorkerData(WorkerData $workerData) {
        $this->_workerData = $workerData;
    }

    public function getWorkerData() {
        return $this->_workerData;
    }
}