<?php

namespace app\controllers;

use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveLastFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\implementation\weatherData\WeatherDataManager;
use app\utils\Limit;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\dataAccess\entities\WeatherPollingDataEntity;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $manager = new WeatherDataManager();
        $result = $manager->retrieve(
            new WeatherDataRetrieveLastFilter(),
            new Limit(),
            new WeatherDataRetrieveOrder()
        );
        VarDumper::dump($result, 10, true);
        return $this->render('index.twig');
    }

}
