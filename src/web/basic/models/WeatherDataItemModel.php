<?php
/**
 * Created by PhpStorm.
 * User: SolopiyA
 * Date: 10.07.2015
 * Time: 13:36
 */

namespace app\models;


use Yii;
use yii\base\Model;

class WeatherDataItemModel extends Model {
    public $id;

    public $temp;

    public $pressure;

    public $alt;

    public $dateTime;

    public $sensorId;

    public function attributeLabels() {
        return [
            'id'       => Yii::t('app', '#ID#'),
            'temp'     => Yii::t('app', '#Temperature#'),
            'pressure' => Yii::t('app', '#Pressure#'),
            'alt'      => Yii::t('app', '#Altitude#'),
            'dateTime' => Yii::t('app', '#Date#'),
        ];
    }

    public function rules() {
        return [
            [['temp', 'pressure', "sensorId", "alt"], 'required']
        ];
    }
}