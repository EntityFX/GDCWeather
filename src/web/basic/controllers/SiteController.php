<?php

namespace app\controllers;

use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\implementation\weatherData\WeatherDataManager;
use app\utils\dataProvider\SimpleListDataProvider;
use app\utils\enum\OrderDirectionEnum;
use app\utils\Limit;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\dataAccess\entities\WeatherPollingDataEntity;

class SiteController extends Controller {
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex() {
        $manager = new WeatherDataManager();

        $limit = new Limit();


        $manager->retrieveChartData(new WeatherDataRetrieveFilter());

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
            new WeatherDataRetrieveFilter(),
            $limit,
            new WeatherDataRetrieveOrder(new OrderDirectionEnum(OrderDirectionEnum::DESC))
        );

        $weatherDataProvider->setModels($result->dataItems);
        $weatherDataProvider->setTotalCountInResult($result->totalItems);

        //var_dump($weatherDataProvider);

        //$weatherDataProvider->setModels($result->dataItems);
        //$weatherDataProvider->setTotalCount($result->totalItems);
        $model = [
            'weatherDataProviderModel' => $weatherDataProvider,
            'weatherStatistics' => $result->statistics,
            'filterDropdowns'   => [
                'intervalList' => $manager->getIntervalsList()
            ]
        ];

        //VarDumper::dump($result, 10, true);
        return $this->render('index.twig', $model);
    }

    public function actionData() {
        $manager = new WeatherDataManager();

        return Json::encode($manager->retrieveChartData(new WeatherDataRetrieveFilter()));
    }
}
