<?php
/**
 * Created by PhpStorm.
 * User: odroid
 * Date: 7/7/15
 * Time: 4:37 a.m.
 */

namespace app\businessLogic\contracts\weatherData;


use yii\base\Object;

/**
 * Class WeatherChartItem
 * @package app\businessLogic\contracts\weatherData
 * @property int $key
 * @property float $temperature
 * @property float $pressure
 * @property float $mmHg
 * @property \DateTime $startDateTime
 * @property \DateTime $endDateTime
 */
class WeatherChartItem extends Object {
    /**
     * @var int
     */
    private $_key;

    /**
     * @var \DateTime
     */
    private $_startDateTime;

    /**
     * @var \DateTime
     */
    private $_endDateTime;
    /**
     * @var float
     */
    private $_temperature;

    /**
     * @var float
     */
    private $_pressure;

    /**
     * @return float
     */
    public function getPressure() {
        return $this->_pressure;
    }

    /**
     * @param float $pressure
     */
    public function setPressure($pressure) {
        $this->_pressure = (float)$pressure;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime() {
        return $this->_endDateTime;
    }

    /**
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime($endDateTime) {
        $this->_endDateTime = $endDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime() {
        return $this->_startDateTime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setStartDateTime(\DateTime $datetime) {
        $this->_startDateTime = $datetime;
    }

    /**
     * @return int
     */
    public function getKey() {
        return $this->_key;
    }

    /**
     * @param int $key
     */
    public function setKey($key) {
        $this->_key = (int)$key;
    }

    /**
     * @return string
     */
    public function getTemperature() {
        return $this->_temperature;
    }

    /**
     * @param string $value
     */
    public function setTemperature($value) {
        $this->_temperature = (float)$value;
    }

    public function getMmHg() {
        return $this->_pressure / 1000 * 7.5006;
    }
}