<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\dataAccess\entities;


use yii\db\ActiveRecord;

class SensorEntity extends ActiveRecord {

    public static function tableName() {
        return 'Sensor';
    }

    public function getVendor() {
        return $this->hasOne(SensorVendorEntity::className(), ['id' => 'vendorId']);
    }
}