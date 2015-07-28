<?php


namespace app\businessLogic\contracts\weatherData\enums;


use app\utils\enum\EnumBase;

/**
 * Class WeatherDataBackIntervalEnum
 *
 * @author  ${USER}
 * @package app\businessLogic\contracts\weatherData\enums
 */
class WeatherDataBackIntervalEnum extends EnumBase {
    const LAST_HOUR      = 1;
    const LAST_THREE_HOURS = 2;
    const LAST_SIX_HOURS = 3;
    const LAST_HALF_DAY  = 4;
    const LAST_DAY       = 5;
    const LAST_WEEK      = 6;
    const LAST_MONTH     = 7;
    const LAST_YEAR      = 8;
}