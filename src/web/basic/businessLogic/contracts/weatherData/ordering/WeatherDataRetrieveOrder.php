<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 2:00
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData\ordering;


use app\utils\order\OrderBase;

class WeatherDataRetrieveOrder extends OrderBase {

    const PARAMETER_TEMPERATURE = "temperature";
    const TEMPERATURE = 1;

    const PARAMETER_PRESSURE = "pressure";
    const PRESSURE    = 2;

    const PARAMETER_TIME = "time";
    const TIME        = 3;

    const PARAMETER_ALTITUDE = "altitude";
    const ALTITUDE    = 4;

    /**
     * @return string[]
     */
    protected function getOrderFields() {
        return [
            self::ID                 => self::ID,
            self::PARAMETER_TEMPERATURE => self::TEMPERATURE,
            self::PARAMETER_PRESSURE => self::PRESSURE,
            self::PARAMETER_TIME     => self::TIME,
            self::PARAMETER_ALTITUDE => self::ALTITUDE
        ];
    }

    /**
     * @return string
     */
    protected function defaultAttribute() {
        return self::ID;
    }
}