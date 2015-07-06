<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:47
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData\enums;


use app\utils\enum\EnumBase;

class WeatherDataFilterTypeEnum extends EnumBase {
    const RANGE_FILTER = 0;
    const LAST_DATA    = 1;
}