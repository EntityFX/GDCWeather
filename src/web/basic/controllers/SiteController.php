<?php

namespace app\controllers;

use app\businessLogic\contracts\sensor\enums\SensorTypeEnum;
use app\businessLogic\contracts\sensor\ordering\SensorOrder;
use app\businessLogic\contracts\sensor\Sensor;
use app\businessLogic\contracts\sensor\SensorVendor;
use app\businessLogic\contracts\weatherData\enums\WeatherChartPointsCountEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\sensor\ordering\SensorVendorOrder;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\businessLogic\implementation\sensor\SensorManager;
use app\businessLogic\implementation\sensor\SensorVendorManager;
use app\models\FilterFormModel;
use app\models\WeatherDataItemModel;
use entityfx\utils\dataProvider\SimpleListDataProvider;
use entityfx\utils\enum\OrderDirectionEnum;
use entityfx\utils\Guid;
use entityfx\utils\Limit;
use entityfx\utils\objectHistory\contracts\enums\HistoryTypeEnum;
use entityfx\utils\objectHistory\contracts\ObjectHistory;
use entityfx\utils\objectHistory\implementation\mapper\ObjectHistoryMapper;
use entityfx\utils\objectHistory\implementation\repositories\ObjectHistoryRepository;
use entityfx\utils\webService\implementation\clientProxies\mapper\ClientProxyEndpointMapper;
use entityfx\utils\webService\implementation\clientProxies\mapper\ClientProxyMapper;
use entityfx\utils\webService\implementation\clientProxies\repositories\WebClientProxyRepository;
use entityfx\utils\workers\implementation\mapper\WorkerMapper;
use entityfx\utils\workers\implementation\repositories\WorkerRepository;
use entityfx\utils\workers\implementation\WorkerManager;
use entityfx\utils\workers\WorkerFactory;
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
     * @param string $id
     * @param \yii\base\Module $module
     * @param WeatherDataManagerInterface $weatherManager
     * @param array $config
     */
    public function __construct($id, $module, WeatherDataManagerInterface $weatherManager, $config = []) {
        parent::__construct($id, $module, $config);
        $this->_weatherManager = $weatherManager;

        //$clientProxyRepository = new WebClientProxyRepository(new ClientProxyMapper(), new ClientProxyEndpointMapper());
        //$wm = new WorkerManager(new WorkerRepository(new WorkerMapper()));
        //WorkerFactory::createWorkerAndRun(1);

        $objectHistoryRepository = new ObjectHistoryRepository(new ObjectHistoryMapper());
        $dm = new ObjectHistory();
        $dm->guid = Guid::generate();
        $dm->type = new HistoryTypeEnum(HistoryTypeEnum::CREATE);
        $dm->category = 0;
        $dm->priority = 1;
        $objectHistoryRepository->store($dm);
        $objectHistoryRepository->read(new \DateTime('today'), new \DateTime('now'));
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
                self::prepareStaticWeatherDataModel($result->dataItems)
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
     * @return WeatherDataItemModel[]
     */
    private static function prepareStaticWeatherDataModel(array $weatherDataItems) {
        $result       = [];
        /** @var WeatherDataItem $item */
        foreach ($weatherDataItems as $item) {
            $modelItem           = new WeatherDataItemModel();
            $modelItem->id       = $item->id;
            $modelItem->temp     = $item->temperature;
            $modelItem->pressure = $item->mmHg;
            $modelItem->alt      = $item->altitude;
            $modelItem->dateTime = $item->createDateTime;
            $result[] = $modelItem;
        }

        return $result;
    }
}
