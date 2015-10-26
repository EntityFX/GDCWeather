<?php

namespace app\utils\workers\contracts\events;

use app\utils\workers\contracts\enums\WorkerEventStatusEnum;
use yii\base\Event;


/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class WorkerEvent extends Event {
    /**
     * @var WorkerEventStatusEnum
     */
    private $_status;

    /**
     * @return WorkerEventStatusEnum
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * @param WorkerEventStatusEnum $status
     */
    public function setStatus($status) {
        $this->_status = $status;
    }
}