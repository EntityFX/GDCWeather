<?php

/**
 * Created by PhpStorm.
 * User: odroid
 * Date: 7/7/15
 * Time: 5:18 a.m.
 */

namespace app\controllers;

use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveLastFilter;
use app\businessLogic\implementation\weatherData\WeatherDataManager;
use app\models\ChartDataItemModel;

class ChartDataController extends \yii\rest\Controller {
    public function actionGet() {
        $manager = new WeatherDataManager();
        $items = $manager->retrieveChartData(new WeatherDataRetrieveLastFilter());
        foreach($items as $item) {
            $res = new ChartDataItemModel();
            $res->id = $item->key;
            $res->temperature = $item->value;
            $res->dateTime = $item->dateTime->format(\DateTime::ISO8601);
            yield $res;
        }
    }
}