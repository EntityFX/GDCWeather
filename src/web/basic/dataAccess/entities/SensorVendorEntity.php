<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\dataAccess\entities;


use yii\db\ActiveRecord;

class SensorVendorEntity extends ActiveRecord {

    public static function tableName() {
        return 'SensorVendor';
    }
}