<?php
namespace app\businessLogic\contracts\sensor;

use app\businessLogic\contracts\sensor\ordering\SensorOrder;
use app\utils\Guid;
use app\utils\Limit;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
interface SensorManagerInterface {
    function create(Sensor $sensorVendor);

    function retrieve(Limit $limit, SensorOrder $order);

    function getById(Guid $id);

    function update(Sensor $sensorVendor);

    function delete(Guid $id);
}