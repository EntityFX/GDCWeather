<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 2:00
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\sensor\ordering;


use entityfx\utils\order\OrderBase;

class SensorVendorOrder extends OrderBase {

    const PARAMETER_NAME = "name";
    const NAME           = 1;

    /**
     * @return string[]
     */
    protected function getOrderFields() {
        return [
            self::ID             => self::ID,
            self::PARAMETER_NAME => self::NAME,
        ];
    }

    /**
     * @return string
     */
    protected function defaultAttribute() {
        return self::ID;
    }
}