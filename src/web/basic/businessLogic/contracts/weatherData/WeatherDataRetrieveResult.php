<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:56
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData;

use entityfx\utils\RetrieveResult;

/**
 * Class WeatherDataRetrieveResult
 *
 * @package app\businessLogic\contracts\weatherData
 * @property WeatherDataItem[]     $dataItems
 * @property WeatherDataItem       $lastMeasure
 * @property WeatherDataStatistics $statistics
 * @property int                   $totalItems
 */
class WeatherDataRetrieveResult extends RetrieveResult {

    /**
     * @var WeatherDataStatistics
     */
    private $_statistics;
    /**
     * @var WeatherDataItem
     */
    private $_lastMeasure;

    /**
     * @return WeatherDataItem[]
     */
    public function getLastMeasure() {
        return $this->_lastMeasure;
    }

    /**
     * @param WeatherDataItem $lastMeasure
     */
    public function setLastMeasure(WeatherDataItem $lastMeasure) {
        $this->_lastMeasure = $lastMeasure;
    }

    /**
     * @return \app\businessLogic\contracts\weatherData\WeatherDataStatistics
     */
    public function getStatistics() {
        return $this->_statistics;
    }

    /**
     * @param \app\businessLogic\contracts\weatherData\WeatherDataStatistics $statistics
     */
    public function setStatistics(WeatherDataStatistics $statistics) {
        $this->_statistics = $statistics;
    }
}