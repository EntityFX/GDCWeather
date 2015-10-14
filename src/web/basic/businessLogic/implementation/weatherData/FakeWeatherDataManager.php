<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\businessLogic\implementation\weatherData;


use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherChartItem;
use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\businessLogic\contracts\weatherData\WeatherDataRetrieveResult;
use app\businessLogic\contracts\weatherData\WeatherDataStatistics;
use app\utils\Limit;
use app\utils\ManagerBase;

class FakeWeatherDataManager extends ManagerBase implements WeatherDataManagerInterface {

    private $_sampleData = [
        ["temperature" => 24.0, "altitude" => 15.0, "pressure" => 98000.0],
        ["temperature" => 24.5, "altitude" => 15.7, "pressure" => 98100.0],
        ["temperature" => 24.6, "altitude" => 15.4, "pressure" => 98200.0],
        ["temperature" => 23.2, "altitude" => 15.3, "pressure" => 98156.0],
        ["temperature" => 25.0, "altitude" => 15.7, "pressure" => 98304.0],
        ["temperature" => 24.5, "altitude" => 15.9, "pressure" => 98190.0],
        ["temperature" => 25.3, "altitude" => 16.0, "pressure" => 98205.0],
        ["temperature" => 25.1, "altitude" => 15.1, "pressure" => 98156.0],
        ["temperature" => 24.8, "altitude" => 15.3, "pressure" => 98000.0],
        ["temperature" => 23.6, "altitude" => 15.6, "pressure" => 98100.0],
        ["temperature" => 22.9, "altitude" => 15.8, "pressure" => 98200.0],
        ["temperature" => 25.6, "altitude" => 15.1, "pressure" => 98156.0],
        ["temperature" => 27.3, "altitude" => 15.6, "pressure" => 98304.0],
        ["temperature" => 25.6, "altitude" => 15.3, "pressure" => 98190.0],
        ["temperature" => 24.7, "altitude" => 15.4, "pressure" => 98205.0],
        ["temperature" => 25.4, "altitude" => 15.015, "pressure" => 98156.0],
    ];

    private $_sampleStatisticsData = [
        [
            "avgTemperature" => 24.0, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.0,
            "avgPressure"    => 98000.0, "minPressure" => 98000.0, "maxPressure" => 98000.0
        ],
        [
            "avgTemperature" => 24.5, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.7,
            "avgPressure"    => 98100.0, "minPressure" => 98100.0, "maxPressure" => 98100.0
        ],
        [
            "avgTemperature" => 24.6, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.4,
            "avgPressure"    => 98200.0, "minPressure" => 98200.0, "maxPressure" => 98200.0
        ],
        [
            "avgTemperature" => 23.2, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.3,
            "avgPressure"    => 98156.0, "minPressure" => 98156.0, "maxPressure" => 98156.0
        ],
        [
            "avgTemperature" => 25.0, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.7,
            "avgPressure"    => 98304.0, "minPressure" => 98304.0, "maxPressure" => 98304.0
        ],
        [
            "avgTemperature" => 24.5, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.9,
            "avgPressure"    => 98190.0, "minPressure" => 98190.0, "maxPressure" => 98190.0
        ],
        [
            "avgTemperature" => 25.3, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 16.0,
            "avgPressure"    => 98205.0, "minPressure" => 98205.0, "maxPressure" => 98205.0
        ],
        [
            "avgTemperature" => 25.1, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.1,
            "avgPressure"    => 98156.0, "minPressure" => 98156.0, "maxPressure" => 98156.0
        ],
        [
            "avgTemperature" => 24.8, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.3,
            "avgPressure"    => 98000.0, "minPressure" => 98000.0, "maxPressure" => 98000.0
        ],
        [
            "avgTemperature" => 23.6, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.6,
            "avgPressure"    => 98100.0, "minPressure" => 98100.0, "maxPressure" => 98100.0
        ],
        [
            "avgTemperature" => 22.9, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.8,
            "avgPressure"    => 98200.0, "minPressure" => 98200.0, "maxPressure" => 98200.0
        ],
        [
            "avgTemperature" => 25.6, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.1,
            "avgPressure"    => 98156.0, "minPressure" => 98156.0, "maxPressure" => 98156.0
        ],
        [
            "avgTemperature" => 27.3, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.6,
            "avgPressure"    => 98304.0, "minPressure" => 98304.0, "maxPressure" => 98304.0
        ],
        [
            "avgTemperature" => 25.6, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.3,
            "avgPressure"    => 98190.0, "minPressure" => 98190.0, "maxPressure" => 98190.0
        ],
        [
            "avgTemperature" => 24.7, "maxTemperature" => 24.0, "minTemperature" => 24.0, "avgAltitude" => 15.4,
            "avgPressure"    => 98205.0, "minPressure" => 98205.0, "maxPressure" => 98205.0
        ],
        [
            "avgTemperature" => 25.4, "maxTemperature" => 25.9, "minTemperature" => 23.2, "avgAltitude" => 15.015,
            "avgPressure"    => 98156.0, "minPressure" => 98205.0, "maxPressure" => 98205.0
        ],
    ];

    /**
     * @param WeatherDataRetrieveFilter $filter
     *
     * @param \app\utils\Limit          $limit
     * @param WeatherDataRetTrieveOrder $order
     *
     * @return WeatherDataRetrieveResult$result
     */
    function retrieve(WeatherDataRetrieveFilter $filter, Limit $limit, WeatherDataRetrieveOrder $order) {
        $result = new WeatherDataRetrieveResult();

        $dataItems = null;

        $result->dataItems = self::buildSampleWeatherDataItems($this->_sampleData);

        $lastStatisticsItem                     = end($this->_sampleStatisticsData);
        $result->statistics                     = new WeatherDataStatistics();
        $result->statistics->maximumTemperature = $lastStatisticsItem["maxTemperature"];
        $result->statistics->minimumTemperature = $lastStatisticsItem["minTemperature"];
        $result->statistics->averageTemperature = $lastStatisticsItem["avgTemperature"];
        $result->statistics->maximumPressure    = $lastStatisticsItem["maxPressure"];
        $result->statistics->minimumPressure    = $lastStatisticsItem["minPressure"];
        $result->statistics->averagePressure    = $lastStatisticsItem["avgPressure"];

        $lastDataItem         = end($this->_sampleData);
        $lastDataItem["date"] = new \DateTime();
        $result->lastMeasure  = self::buildSampleWeatherDataItem($lastDataItem);

        return $result;
    }

    /**
     * @param WeatherDataRetrieveFilter $filter
     * @return WeatherChartItem[]
     */
    function retrieveChartData(WeatherDataRetrieveFilter $filter) {
        return self::buildSampleChartDataItems($this->_sampleStatisticsData);
    }

    function getIntervalsList() {
        return [
            WeatherDataBackIntervalEnum::LAST_HOUR        => 'Last hour',
            WeatherDataBackIntervalEnum::LAST_THREE_HOURS => 'Last 3 hours',
            WeatherDataBackIntervalEnum::LAST_SIX_HOURS   => 'Last 6 hours',
            WeatherDataBackIntervalEnum::LAST_HALF_DAY    => 'Last 12 hours',
            WeatherDataBackIntervalEnum::LAST_DAY         => 'Last day',
            WeatherDataBackIntervalEnum::LAST_WEEK        => 'Last week',
            WeatherDataBackIntervalEnum::LAST_YEAR        => 'Last year',
        ];
    }

    private static function buildSampleWeatherDataItem(array $data) {
        $weatherDataItem                 = new WeatherDataItem();
        $weatherDataItem->altitude       = $data["altitude"];
        $weatherDataItem->temperature    = $data["temperature"];
        $weatherDataItem->pressure       = $data["pressure"];
        $weatherDataItem->createDateTime = $data["date"];

        return $weatherDataItem;
    }

    private static function  buildSampleWeatherDataItems(array $sampleData) {
        $dataItems = null;
        $date      = new \DateTime("today");
        foreach ($sampleData as $sampleDataItem) {
            $sampleDataItem["date"] = clone $date;
            $date->add(\DateInterval::createFromDateString("1 hour"));
            $dataItems[] = self::buildSampleWeatherDataItem($sampleDataItem);
        }

        return $dataItems;
    }

    private static function buildSampleChartDataItem(array $data) {
        $weatherDataItem                     = new WeatherChartItem();
        $weatherDataItem->averageTemperature = $data["avgTemperature"];
        $weatherDataItem->averagePressure    = $data["avgPressure"];
        $weatherDataItem->minimumTemperature = $data["minTemperature"];
        $weatherDataItem->maximumTemperature = $data["maxTemperature"];
        $weatherDataItem->startDateTime      = $data["date"];

        return $weatherDataItem;
    }

    private static function  buildSampleChartDataItems(array $sampleData) {
        $dataItems = null;
        $date      = new \DateTime("today");
        foreach ($sampleData as $sampleDataItem) {
            $sampleDataItem["date"] = clone $date;
            $date->add(\DateInterval::createFromDateString("1 hour"));
            $dataItems[] = self::buildSampleChartDataItem($sampleDataItem);
        }

        return $dataItems;
    }
}