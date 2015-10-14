<?php

namespace app\controllers;

use app\businessLogic\contracts\weatherData\enums\WeatherChartPointsCountEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\models\FilterFormModel;
use app\models\WeatherDataItemModel;
use app\utils\dataProvider\SimpleListDataProvider;
use app\utils\enum\OrderDirectionEnum;
use app\utils\Limit;
use Yii;
use yii\web\Controller;

/**
 * Class SiteController
 *
 * @author  ${USER}
 * @package app\controllers
 */
class SiteController extends Controller {
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

    /**
     * @return array
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex() {

        $filterFormModel = new FilterFormModel();
        $retrieveFilter  = new WeatherDataRetrieveFilter();
        if (Yii::$app->request->isPost) {
            $filterFormModel->attributes = Yii::$app->request->post('FilterFormModel');
            if ($filterFormModel->validate()) {
                $retrieveFilter->backInterval = new WeatherDataBackIntervalEnum((int)$filterFormModel->backPeriod);
            }
        }


        $limit = new Limit();

        $this->_weatherManager->retrieveChartData($retrieveFilter);

        //var_dump($result->totalItems);

        $weatherDataProvider = new SimpleListDataProvider(
            [
                //'allModels'  => $result->dataItems,
                'sort'       => [
                    'attributes' => ['id'],
                ],
                'pagination' => [
                    'pageSize' => $limit->getSize(),
                ],
                //'totalCountInResult' => $result->totalItems
            ]
        );

        $result = $this->_weatherManager->retrieve(
            $retrieveFilter,
            $limit,
            new WeatherDataRetrieveOrder(new OrderDirectionEnum(OrderDirectionEnum::DESC))
        );

        if (!empty($result->dataItems)) {
            $weatherDataProvider->setModels(
                iterator_to_array(self::prepareStaticWeatherDataModel($result->dataItems))
            );
        }

        $weatherDataProvider->setTotalCountInResult($result->totalItems);

        $pointsCountList = (
        new WeatherChartPointsCountEnum(
            WeatherChartPointsCountEnum::FIFTY
        )
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
            'lastMeasure'                => $result->lastMeasure,
            'filterForm'                 => $filterFormModel,
            'backPeriodDropDownListData' => $this->_weatherManager->getIntervalsList(),
            'chartPointsDropDownListData' => $pointsDropDownData
        ];

        return $this->render('index.twig', $model);
    }

    /**
     * @param array $weatherDataItems
     * @return \Generator
     */
    private static function prepareStaticWeatherDataModel(array $weatherDataItems) {
        /** @var WeatherDataItem $item */
        foreach ($weatherDataItems as $item) {
            $modelItem           = new WeatherDataItemModel();
            $modelItem->id       = $item->id;
            $modelItem->temp     = $item->temperature;
            $modelItem->pressure = $item->mmHg;
            $modelItem->alt      = $item->altitude;
            $modelItem->dateTime = $item->createDateTime;
            yield $modelItem;
        }
    }
}
