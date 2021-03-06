<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.06.15
 * Time: 20:12
 */

namespace app\businessLogic\contracts\weatherData;

use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use entityfx\utils\Limit;

interface WeatherDataManagerInterface {

    function create(WeatherDataItem $weatherData);

    /**
     * @param WeatherDataRetrieveFilter $filter
     *
     * @param \entityfx\utils\Limit         $limit
     * @param WeatherDataRetrieveOrder $order
     *
     * @return WeatherDataRetrieveResult
     */
    function retrieve(WeatherDataRetrieveFilter $filter, Limit $limit, WeatherDataRetrieveOrder $order);

    /**
     * @param WeatherDataRetrieveFilter $filter
     * @return WeatherChartItem[]
     */
    function retrieveChartData(WeatherDataRetrieveFilter $filter);

    function getIntervalsList();
}