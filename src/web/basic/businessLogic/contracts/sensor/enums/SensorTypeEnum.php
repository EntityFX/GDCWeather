<?php

namespace app\businessLogic\contracts\sensor\enums;
use app\utils\enum\EnumBase;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class SensorTypeEnum extends EnumBase {
    const TEMPERATURE   = 0;
    const ACCELEROMETER = 1;
}