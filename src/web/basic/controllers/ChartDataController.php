<?php

/**
 * Created by PhpStorm.
 * User: odroid
 * Date: 7/7/15
 * Time: 5:18 a.m.
 */

namespace app\controllers;

use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\WeatherChartItem;
use app\businessLogic\implementation\weatherData\WeatherDataManager;
use app\models\ChartDataItemModel;
use yii\filters\auth\HttpBasicAuth;
use Yii;

class ChartDataController extends \yii\rest\Controller {

    /**
     * @param \Iterator $data
     * @return \Generator
     */
    private static function chartDataToModel(\Iterator &$data) {
        /** @var WeatherChartItem $item */
        foreach ($data as $item) {
            $res = new ChartDataItemModel();
            $res->id = $item->key;
            $res->temperature = $item->temperature;
            $res->pressure = $item->pressure;
            $res->mmHg = $item->mmHg;
            $res->dateTime = Yii::$app->formatter->asDatetime($item->startDateTime, "short");
            yield $res;
        }
    }

    public function behaviors() {
        $behaviors                  = parent::behaviors();

        /*$behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];*/

        return $behaviors;
    }

    public function actionIndex() {
        $manager = new WeatherDataManager();
        $items = $manager->retrieveChartData(new WeatherDataRetrieveFilter());

        return iterator_to_array(self::chartDataToModel($items));
    }
}