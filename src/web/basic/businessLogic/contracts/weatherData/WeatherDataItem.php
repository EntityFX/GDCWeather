<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:57
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData;

use app\utils\helpers\DateTimeHelper;
use DateTime;
use yii\base\Object;

/**
 * Class WeatherDataItem
 *
 * @package app\bussinesLogic\contracts\weatherData
 *
 * @property int $id
 * @property float $temperature
 * @property float $altitude
 * @property float $pressure
 * @property DateTime $createDateTime
 */
class WeatherDataItem extends Object {
    /**
     * @var int
     */
    private $_id;

    /**
     * @var float
     */
    private $_temperature;

    /**
     * @var float
     */
    private $_altitude;

    /**
     * @var float
     */
    private $_pressure;

    /**
     * @var DateTime
     */
    private $_createDateTime;

    /**
     * @param float $altitude
     */
    public function setAltitude($altitude) {
        $this->_altitude = (float)$altitude;
    }

    /**
     * @return float
     */
    public function getAltitude() {
        return $this->_altitude;
    }

    /**
     * @param \DateTime $createDateTime
     */
    public function setCreateDateTime(DateTime $createDateTime) {
        $this->_createDateTime = $createDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDateTime() {
        return $this->_createDateTime;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * @return int
     */
    public function getId() {
        return (int)$this->_id;
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
    public function getPressure() {
        return $this->_pressure;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature($temperature) {
        $this->_temperature = (float)$temperature;
    }

    /**
     * @return float
     */
    public function getTemperature() {
        return $this->_temperature;
    }

}