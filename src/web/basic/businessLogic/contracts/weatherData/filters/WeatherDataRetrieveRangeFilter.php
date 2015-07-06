<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:49
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData\filters;


use app\businessLogic\contracts\weatherData\enums\WeatherDataFilterTypeEnum;

class WeatherDataRetrieveRangeFilter extends WeatherDataRetrieveFilterBase {
    /**
     * @return WeatherDataFilterTypeEnum
     */
    protected function initFilterType() {
        return new WeatherDataFilterTypeEnum(WeatherDataFilterTypeEnum::RANGE_FILTER);
    }
}