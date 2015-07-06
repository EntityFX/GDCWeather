<?php
namespace app\businessLogic\contracts\weatherData\filters;

use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataFilterTypeEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilterBase;
use yii\helpers\VarDumper;

/**
 * Class WeatherDataRetrieveLastFilter
 *
 * @package app\businessLogic\contracts\weatherData\filters
 *
 * @property WeatherDataBackIntervalEnum $backInterval
 */
class WeatherDataRetrieveLastFilter extends WeatherDataRetrieveFilterBase {

    /**
     * @var WeatherDataBackIntervalEnum
     */
    private $_backInterval;

    /**
     * @param \app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum $backInterval
     */
    public function setBackInterval(WeatherDataBackIntervalEnum $backInterval) {
        $this->_backInterval = $backInterval;
    }

    /**
     * @return \app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum
     */
    public function getBackInterval() {
        return $this->_backInterval;
    }

    function __construct(WeatherDataBackIntervalEnum $backInterval = null) {
        parent::__construct();
        if ($this->_backInterval === null ) {
            $this->_backInterval = new WeatherDataBackIntervalEnum(WeatherDataBackIntervalEnum::LAST_TEN_MINUTES);
        }
    }


    /**
     * @return WeatherDataFilterTypeEnum
     */
    protected function initFilterType() {
        return new WeatherDataFilterTypeEnum(WeatherDataFilterTypeEnum::LAST_DATA);
    }
}