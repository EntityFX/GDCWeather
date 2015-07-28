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
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\models\ChartDataItemModel;
use app\models\ChartDataRequestModel;
use Yii;

class ChartDataController extends \yii\rest\Controller {
    /**
     * @var WeatherDataManagerInterface
     */
    private $_weatherManager;

    /**
     * @param string                      $id
     * @param \yii\base\Module            $module
     * @param WeatherDataManagerInterface $weatherManager
     * @param array                       $config
     */
    public function __construct($id, $module, WeatherDataManagerInterface $weatherManager, $config = []) {
        parent::__construct($id, $module, $config);
        $this->_weatherManager = $weatherManager;
    }

    public function behaviors() {
        $behaviors = parent::behaviors();

        /*$behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];*/

        return $behaviors;
    }

    public function actionIndex() {

        $model             = new ChartDataRequestModel();
        $model->attributes = Yii::$app->request->get();
        if ($model->validate()) {
            $retrieveChartDataFilter               = new WeatherDataRetrieveFilter();
            $retrieveChartDataFilter->countPoints  = $model->pointsCount;
            $retrieveChartDataFilter->backInterval = new WeatherDataBackIntervalEnum((int)$model->period);
            $items = $this->_weatherManager->retrieveChartData($retrieveChartDataFilter);

            return iterator_to_array(self::chartDataToModel($items));
        }

        return [];
    }

    /**
     * @param \Iterator $data
     * @return \Generator
     */
    private static function chartDataToModel(\Iterator &$data) {
        /** @var WeatherChartItem $item */
        foreach ($data as $item) {
            $res                     = new ChartDataItemModel();
            $res->id                 = $item->key;
            $res->averageTemperature = $item->averageTemperature;
            $res->maximumTemperature = $item->maximumTemperature;
            $res->minimumTemperature = $item->minimumTemperature;
            $res->averagePressure    = $item->averagePressure;
            $res->averageMmHg        = $item->averageMmHg;
            $res->dateTime           = Yii::$app->formatter->asDatetime($item->startDateTime, "short");
            yield $res;
        }
    }
}