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
 * @property float $value
 * @property \DateTime $datetime
 */
class WeatherChartItem extends Object{
    /**
     * @var int
     */
    private $_key;

    /**
     * @var \DateTime
     */
    private $_datetime;

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->_datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime(\DateTime $datetime)
    {
        $this->_datetime = $datetime;
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
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->_value = (float)$value;
    }

    /**
     * @var string
     */
    private $_value;
}