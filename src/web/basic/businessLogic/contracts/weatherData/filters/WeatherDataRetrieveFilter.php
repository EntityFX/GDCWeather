<?php
namespace app\businessLogic\contracts\weatherData\filters;

use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataFilterTypeEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilterBase;
use yii\base\Object;

/**
 * Class WeatherDataRetrieveFilter
 *
 * @package app\businessLogic\contracts\weatherData\filters
 *
 * @property WeatherDataBackIntervalEnum $backInterval
 * @property \DateTime                   $startDateTime
 * @property int                         $countPoints
 */
class WeatherDataRetrieveFilter extends Object {

    /**
     * @var WeatherDataBackIntervalEnum
     */
    private $_backInterval;

    /**
     * @var int
     */
    private $_countPoints = 50;

    /**
     * @param int $countPoints
     */
    public function setCountPoints($countPoints) {
        $this->_countPoints = (int)$countPoints;
    }

    /**
     * @return int
     */
    public function getCountPoints() {
        return $this->_countPoints;
    }

    /**
     * @param \DateTime $startDateTime
     */
    public function setStartDateTime($startDateTime) {
        $this->_startDateTime = $startDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime() {
        return $this->_startDateTime;
    }

    /**
     * @var \DateTime
     */
    private $_startDateTime;

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
        $this->_backInterval = $backInterval === null
            ? $this->_backInterval = new WeatherDataBackIntervalEnum(WeatherDataBackIntervalEnum::LAST_HOUR)
            : $backInterval;


        $this->_startDateTime = new \DateTime();
    }
}