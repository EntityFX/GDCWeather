<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.06.15
 * Time: 20:12
 */

namespace app\bussinesLogic\contracts;

interface WeatherDataManagerInterface {
    function retrieve(WeatherDataRetrieveFilter $filter);
}