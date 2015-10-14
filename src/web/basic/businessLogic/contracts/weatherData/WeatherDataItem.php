<?php

namespace app\businessLogic\contracts\weatherData;

use DateTime;
use yii\base\Object;

/**
 * Class WeatherDataItem
 *
 * @package app\bussinesLogic\contracts\weatherData
 *
 * @property int   $id
 * @property float $temperature
 * @property float $altitude
 * @property float $pressure
 * @property float $mmHg
 * @property DateTime $createDateTime
 */
class WeatherDataItem extends Object {
    /**
     * @var int
     */
    private $_id = 0;

    /**
     * @var float
     */
    private $_temperature = 0.0;

    /**
     * @var float
     */
    private $_altitude = 0.0;

    /**
     * @var float
     */
    private $_pressure = 0.0;

    /**
     * @var DateTime
     */
    private $_createDateTime;

    /**
     * @return float
     */
    public function getAltitude() {
        return $this->_altitude;
    }

    /**
     * @param float $altitude
     */
    public function setAltitude($altitude) {
        $this->_altitude = (float)$altitude;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime() {
        return $this->_createDateTime;
    }

    /**
     * @param \DateTime $createDateTime
     */
    public function setCreateDateTime(DateTime $createDateTime) {
        $this->_createDateTime = $createDateTime;
    }

    /**
     * @return int
     */
    public function getId() {
        return (int)$this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

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
     * @return float
     */
    public function getMmHg() {
        return WeatherChartItem::calculateMmHg($this->_pressure);
    }

    /**
     * @return float
     */
    public function getTemperature() {
        return $this->_temperature;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature($temperature) {
        $this->_temperature = (float)$temperature;
    }

}