<?php

namespace app\businessLogic\contracts\weatherData;

use yii\base\Object;

/**
 * Class WeatherChartItem
 * @package app\businessLogic\contracts\weatherData
 * @property int   $key
 * @property float $averageTemperature
 * @property float $maximumTemperature
 * @property float $minimumTemperature
 * @property float $averagePressure
 * @property float $averageMmHg
 * @property \DateTime $startDateTime
 * @property \DateTime $endDateTime
 */
class WeatherChartItem extends Object
{
    /**
     * @var int
     */
    private $_key = 0;

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
    private $_averageTemperature = 0.0;

    /**
     * @var float
     */
    private $_maximumTemperature = 0.0;
    /**
     * @var float
     */
    private $_minimumTemperature = 0.0;
    /**
     * @var float
     */
    private $_averagePressure = 0.0;

    /**
     * @return float
     */
    public function getMaximumTemperature()
    {
        return $this->_maximumTemperature;
    }

    /**
     * @param float $maximumTemperature
     */
    public function setMaximumTemperature($maximumTemperature)
    {
        $this->_maximumTemperature = $maximumTemperature;
    }

    /**
     * @return float
     */
    public function getMinimumTemperature()
    {
        return $this->_minimumTemperature;
    }

    /**
     * @param float $minimumTemperature
     */
    public function setMinimumTemperature($minimumTemperature)
    {
        $this->_minimumTemperature = $minimumTemperature;
    }

    /**
     * @return float
     */
    public function getAveragePressure()
    {
        return $this->_averagePressure;
    }

    /**
     * @param float $pressure
     */
    public function setAveragePressure($pressure)
    {
        $this->_averagePressure = (float)$pressure;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime()
    {
        return $this->_endDateTime;
    }

    /**
     * @param \DateTime $endDateTime
     */
    public function setEndDateTime($endDateTime)
    {
        $this->_endDateTime = $endDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime()
    {
        return $this->_startDateTime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setStartDateTime(\DateTime $datetime)
    {
        $this->_startDateTime = $datetime;
    }

    /**
     * @return int
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * @param int $key
     */
    public function setKey($key)
    {
        $this->_key = (int)$key;
    }

    /**
     * @return string
     */
    public function getAverageTemperature()
    {
        return $this->_averageTemperature;
    }

    /**
     * @param string $value
     */
    public function setAverageTemperature($value)
    {
        $this->_averageTemperature = (float)$value;
    }

    /**
     * @return float
     */
    public function getAverageMmHg()
    {
        return static::calculateMmHg($this->_averagePressure);
    }

    /**
     * @param $pressure
     * @return float
     */
    public static function calculateMmHg($pressure)
    {
        return $pressure / 1000 * 7.5006;
    }
}