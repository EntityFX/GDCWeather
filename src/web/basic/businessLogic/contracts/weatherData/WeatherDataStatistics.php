<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:58
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData;


use yii\base\Object;

/**
 * Class WeatherDataStatistics
 * @package app\businessLogic\contracts\weatherData
 *
 * @property float $averageTemperature
 * @property float $minimumTemperature
 * @property float $maximumTemperature
 *
 */
class WeatherDataStatistics extends Object {

    /**
     * @var float
     */
    private $_averageTemperature;

    /**
     * @return float
     */
    public function getAverageTemperature()
    {
        return $this->_averageTemperature;
    }

    /**
     * @param float $averageTemperature
     */
    public function setAverageTemperature($averageTemperature)
    {
        $this->_averageTemperature = (float)$averageTemperature;
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
        $this->_minimumTemperature = (float)$minimumTemperature;
    }

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
        $this->_maximumTemperature = (float)$maximumTemperature;
    }

    /**
     * @var float
     */
    private $_minimumTemperature;

    /**
     * @var float
     */
    private $_maximumTemperature;


}