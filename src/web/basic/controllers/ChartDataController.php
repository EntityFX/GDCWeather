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
use yii\filters\auth\HttpBasicAuth;

class ChartDataController extends \yii\rest\Controller {

    /**
     * @param array $data
     * @return \Generator
     */
    private static function &chartDataToModel(array &$data) {
        foreach ($data as $item) {
            $res = new ChartDataItemModel();
            $res->id = $item->key;
            $res->temperature = $item->value;
            $res->dateTime = $item->dateTime->format(\DateTime::ISO8601);
            yield $res;
        }
    }

    public function behaviors() {
        $behaviors                  = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];

        return $behaviors;
    }

    public function actionIndex() {
        $manager = new WeatherDataManager();
        $items   = $manager->retrieveChartData(new WeatherDataRetrieveLastFilter());

        return iterator_to_array(self::chartDataToModel($items));
    }
}