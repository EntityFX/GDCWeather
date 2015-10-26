<?php

namespace app\utils\workers\dataAccess;
use yii\db\ActiveRecord;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class WorkerEntity extends ActiveRecord {
    public static function tableName() {
        return 'Worker';
    }
}