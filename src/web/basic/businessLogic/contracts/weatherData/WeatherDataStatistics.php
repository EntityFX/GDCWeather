<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:58
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData;


use yii\Object;

/**
 * Class WeatherDataStatistics
 * @package app\businessLogic\contracts\weatherData
 *
 * @property float $averageTemperature
 * @property float $minimumTemperature
 * @property float $maximumTemperature
 * @property float $averagePressure
 * @property float $minimumPressure
 * @property float $maximumPressure
 * @property float $averageMmHg
 * @property float $minimumMmHg
 * @property float $maximumMmHg
 *
 */
class WeatherDataStatistics extends Object {

    /**
     * @var float
     */
    private $_averageTemperature = 0.0;
    /**
     * @var float
     */
    private $_minimumTemperature = 0.0;
    /**
     * @var float
     */
    private $_maximumTemperature = 0.0;

    /**
     * @var float
     */
    private $_averagePressure = 0.0;
    /**
     * @var float
     */
    private $_minimumPressure = 0.0;
    /**
     * @var float
     */
    private $_maximumPressure = 0.0;

    /**
     * @return float
     */
    public function getAveragePressure() {
        return $this->_averagePressure;
    }

    /**
     * @param float $averagePressure
     */
    public function setAveragePressure($averagePressure) {
        $this->_averagePressure = $averagePressure;
    }

    /**
     * @return float
     */
    public function getMinimumPressure() {
        return $this->_minimumPressure;
    }

    /**
     * @param float $minimumPressure
     */
    public function setMinimumPressure($minimumPressure) {
        $this->_minimumPressure = $minimumPressure;
    }

    /**
     * @return float
     */
    public function getMaximumPressure() {
        return $this->_maximumPressure;
    }

    /**
     * @param float $maximumPressure
     */
    public function setMaximumPressure($maximumPressure) {
        $this->_maximumPressure = $maximumPressure;
    }

    /**
     * @return float
     */
    public function getAverageTemperature() {
        return $this->_averageTemperature;
    }

    /**
     * @param float $averageTemperature
     */
    public function setAverageTemperature($averageTemperature) {
        $this->_averageTemperature = (float)$averageTemperature;
    }

    /**
     * @return float
     */
    public function getMinimumTemperature() {
        return $this->_minimumTemperature;
    }

    /**
     * @param float $minimumTemperature
     */
    public function setMinimumTemperature($minimumTemperature) {
        $this->_minimumTemperature = (float)$minimumTemperature;
    }

    /**
     * @return float
     */
    public function getMaximumTemperature() {
        return $this->_maximumTemperature;
    }

    /**
     * @param float $maximumTemperature
     */
    public function setMaximumTemperature($maximumTemperature) {
        $this->_maximumTemperature = (float)$maximumTemperature;
    }

    public function getMaximumMmHg() {
        return WeatherChartItem::calculateMmHg($this->_maximumPressure);
    }

    public function getMinimumMmHg() {
        return WeatherChartItem::calculateMmHg($this->_minimumPressure);
    }

    public function getAverageMmHg() {
        return WeatherChartItem::calculateMmHg($this->_averagePressure);
    }
}