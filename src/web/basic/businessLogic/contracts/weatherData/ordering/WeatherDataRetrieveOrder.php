<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 2:00
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\contracts\weatherData\ordering;


use app\utils\order\OrderBase;

class WeatherDataRetrieveOrder extends OrderBase {

    /**
     * @return string[]
     */
    protected function getOrderFields() {
        return [
            'id', 'temp', 'pressure', 'time'
        ];
    }

    /**
     * @return string
     */
    protected function defaultAttribute() {
        return 'id';
    }
}