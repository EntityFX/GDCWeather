<?php

namespace app\dataAccess\entities;

use yii\db\ActiveRecord;

/**
 * Class WeatherPollingDataEntity
 *
 * @package app\dataAccess\entities
 *
 * @property int $id
 * @property float $temp
 * @property float $alt
 * @property float $pressure
 * @property string $dateTime
 */
class WeatherPollingDataEntity extends ActiveRecord {

    public static function tableName()
    {
        return 'WeatherPollingData';
    }
}