<?php

namespace app\businessLogic\contracts;

use entityfx\utils\enum\EnumBase;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.11.15
 * Time: 14:48
 */
final class ContractObjectHistoryCategoryEnum extends EnumBase
{
    const SENSOR_VENDOR = 1;
    const SENSOR = 2;
    const WEATHER_SENSOR_DATA = 3;
}