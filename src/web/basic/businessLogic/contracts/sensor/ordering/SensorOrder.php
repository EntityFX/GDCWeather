<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\businessLogic\contracts\sensor\ordering;


use app\utils\order\OrderBase;

class SensorOrder extends OrderBase {

    /**
     * @return array
     */
    protected function getOrderFields() {
        return [
            self::ID => self::ID,
        ];
    }

    /**
     * @return string
     */
    protected function defaultAttribute() {
        return self::ID;
    }
}