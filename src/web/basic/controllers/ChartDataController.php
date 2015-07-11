<?php

/**
 * Created by PhpStorm.
 * User: odroid
 * Date: 7/7/15
 * Time: 5:18 a.m.
 */

namespace app\controllers;

use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\WeatherChartItem;
use app\businessLogic\implementation\weatherData\WeatherDataManager;
use app\models\ChartDataItemModel;
use app\models\ChartDataRequestModel;
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
            $res->averageTemperature = $item->averageTemperature;
            $res->maximumTemperature = $item->maximumTemperature;
            $res->minimumTemperature = $item->minimumTemperature;
            $res->averagePressure = $item->averagePressure;
            $res->averageMmHg = $item->averageMmHg;
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

        $model             = new ChartDataRequestModel();
        $model->attributes = Yii::$app->request->get();
        if ($model->validate()) {
            $retrieveChartDataFilter               = new WeatherDataRetrieveFilter();
            $retrieveChartDataFilter->countPoints  = $model->pointsCount;
            $retrieveChartDataFilter->backInterval = new WeatherDataBackIntervalEnum((int)$model->period);
            $items                                 = $manager->retrieveChartData($retrieveChartDataFilter);

            return iterator_to_array(self::chartDataToModel($items));
        }

        return [];
    }
}