<?php

namespace app\controllers;

use app\businessLogic\contracts\weatherData\enums\WeatherChartPointsCountEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\businessLogic\implementation\weatherData\WeatherDataManager;
use app\models\ContactForm;
use app\models\FilterFormModel;
use app\models\LoginForm;
use app\models\WeatherDataItemModel;
use app\utils\dataProvider\SimpleListDataProvider;
use app\utils\enum\OrderDirectionEnum;
use app\utils\Limit;
use Yii;
use yii\helpers\FormatConverter;
use yii\helpers\Json;
use yii\web\Controller;

class SiteController extends Controller {
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex() {

        $filterFormModel = new FilterFormModel();
        $retrieveFilter  = new WeatherDataRetrieveFilter();
        if (Yii::$app->request->isPost) {
            $filterFormModel->attributes = Yii::$app->request->post('FilterFormModel');
            if ($filterFormModel->validate()) {
                $retrieveFilter->backInterval = new WeatherDataBackIntervalEnum((int)$filterFormModel->backPeriod);
            }
        }

        $manager = new WeatherDataManager();

        $limit = new Limit();

        $manager->retrieveChartData($retrieveFilter);

        //var_dump($result->totalItems);

        $weatherDataProvider = new SimpleListDataProvider([
            //'allModels'  => $result->dataItems,
            'sort'       => [
                'attributes' => ['id'],
            ],
            'pagination' => [
                'pageSize' => $limit->getSize(),
            ],
            //'totalCountInResult' => $result->totalItems
        ]);

        $result = $manager->retrieve(
            $retrieveFilter,
            $limit,
            new WeatherDataRetrieveOrder(new OrderDirectionEnum(OrderDirectionEnum::DESC))
        );


        $weatherDataProvider->setModels(
            iterator_to_array(self::prepareStaticWeatherDataModel($result->dataItems))
        );
        $weatherDataProvider->setTotalCountInResult($result->totalItems);

        $pointsCountList = (new WeatherChartPointsCountEnum(WeatherChartPointsCountEnum::FIFTY)
        )->getArray();

        $pointsDropDownData = [];
        foreach ($pointsCountList as $pointItem) {
            $pointsDropDownData[$pointItem] = $pointItem;
        }


        //$weatherDataProvider->setModels($result->dataItems);
        //$weatherDataProvider->setTotalCount($result->totalItems);
        $model = [
            'weatherDataProviderModel'   => $weatherDataProvider,
            'weatherStatistics'          => $result->statistics,
            'filterForm'                 => $filterFormModel,
            'backPeriodDropDownListData'  => $manager->getIntervalsList(),
            'chartPointsDropDownListData' => $pointsDropDownData
        ];

        return $this->render('index.twig', $model);
    }

    private static function prepareStaticWeatherDataModel(array $weatherDataItems) {
        /** @var WeatherDataItem $item */
        foreach ($weatherDataItems as $item) {
            $modelItem           = new WeatherDataItemModel();
            $modelItem->id       = $item->id;
            $modelItem->temp     = $item->temperature;
            $modelItem->pressure = $item->pressure;
            $modelItem->alt      = $item->altitude;
            $modelItem->dateTime = $item->createDateTime;
            yield $modelItem;
        }
    }
}
