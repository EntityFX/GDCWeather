<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 1:56
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData;


use yii\base\Object;

/**
 * Class WeatherDataRetrieveResult
 *
 * @package app\businessLogic\contracts\weatherData
 * @property WeatherDataItem[]     $dataItems
 * @property WeatherDataItem       $lastMeasure
 * @property WeatherDataStatistics $statistics
 * @property int                   $totalItems
 */
class WeatherDataRetrieveResult extends Object {
    /**
     * @var WeatherDataItem[]
     */
    private $_dataItems;

    /**
     * @var WeatherDataStatistics
     */
    private $_statistics;
    /**
     * @var WeatherDataItem
     */
    private $_lastMeasure;
    /**
     * @var int
     */
    private $_totalItems;

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
     * @return int
     */
    public function getTotalItems() {
        return $this->_totalItems;
    }

    /**
     * @param int $totalItems
     */
    public function setTotalItems($totalItems) {
        $this->_totalItems = (int)$totalItems;
    }

    /**
     * @return \app\businessLogic\contracts\weatherData\WeatherDataItem[]
     */
    public function getDataItems() {
        return $this->_dataItems;
    }

    /**
     * @param \app\businessLogic\contracts\weatherData\WeatherDataItem[] $dataItems
     */
    public function setDataItems(array $dataItems) {
        $this->_dataItems = $dataItems;
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