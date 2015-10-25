<?php
namespace app\businessLogic\contracts\sensor;

use app\businessLogic\contracts\sensor\ordering\SensorVendorOrder;
use app\utils\Guid;
use app\utils\Limit;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
interface SensorVendorManagerInterface {
    function create(SensorVendor $sensorVendor);

    function retrieve(Limit $limit, SensorVendorOrder $order);

    function getById(Guid $id);

    function update(SensorVendor $sensorVendor);

    function delete(Guid $id);
}