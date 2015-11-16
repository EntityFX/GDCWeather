<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 16.11.15
 * Time: 17:31
 */

namespace app\controllers;


use app\businessLogic\contracts\sensor\Sensor;
use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\models\WeatherDataItemModel;
use entityfx\utils\Guid;
use entityfx\utils\Limit;
use stdClass;
use Yii;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;

class SensorVendorApiController extends Controller {
    /**
     * @var WeatherDataManagerInterface
     */
    private $_weatherDataManager;

    public function __construct($id, $module, WeatherDataManagerInterface $weatherDataManager, $config = []) {
        parent::__construct($id, $module, $config);
        $this->_weatherDataManager = $weatherDataManager;
    }

    public function actionIndex() {
        $result = $this->_weatherDataManager->retrieve(
            new WeatherDataRetrieveFilter(new WeatherDataBackIntervalEnum(WeatherDataBackIntervalEnum::LAST_HOUR)),
            new Limit(),
            new WeatherDataRetrieveOrder());

        return $result->statistics->toApi();
    }

    public function actionView($id) {
        return $id;
    }

    public function actionCreate() {
        $model = new WeatherDataItemModel();
        $params = Yii::$app->getRequest()->getBodyParams();
        $model->load($params, '');
        if ($model->validate()) {
            $weatherDataItem = new WeatherDataItem();
            $weatherDataItem->temperature = $model->temp;
            $weatherDataItem->pressure = $model->pressure;
            $weatherDataItem->altitude = $model->alt;
            $weatherDataItem->createDateTime = new \DateTime();

            $sensor = new Sensor();
            $sensor->id = Guid::parse($model->sensorId);

            $weatherDataItem->sensor = $sensor;

            try {
                $weatherDataItem = $this->_weatherDataManager->create($weatherDataItem);

                $result = new StdClass();
                $result->guid = $weatherDataItem->id->format();

                $response = Yii::$app->getResponse();
                $response->setStatusCode(201);

                return $result;
            }
            catch(\Exception $exception) {
                throw new ServerErrorHttpException($exception->getMessage());
            }

        } elseif ($model->hasErrors()) {
            return $model;
        }
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
        ];
    }
}