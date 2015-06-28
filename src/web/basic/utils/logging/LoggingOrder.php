<?php

namespace app\utils\logging;
use app\utils\order\OrderBase;

/**
 * Class LoggingOrder
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class LoggingOrder extends OrderBase {

    /**
     * @return array
     */
    protected function getOrderFields() {
        return array(
            'severity' => 'level',
            'category' => 'category',
            'datetime' => 'logtime',
            'id'       => 'id'
        );
    }

    /**
     * @return string
     */
    protected function defaultAttribute() {
        return 'id';
    }
}