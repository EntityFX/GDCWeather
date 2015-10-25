<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\businessLogic\implementation\sensor;


use app\businessLogic\contracts\sensor\ordering\SensorOrder;
use app\businessLogic\contracts\sensor\Sensor;
use app\businessLogic\contracts\sensor\SensorManagerInterface;
use app\businessLogic\implementation\sensor\mapper\SensorMapper;
use app\dataAccess\entities\SensorEntity;
use app\utils\exceptions\ManagerException;
use app\utils\Guid;
use app\utils\Limit;
use app\utils\ManagerBase;
use Yii;
use yii\db\IntegrityException;

class SensorManager extends ManagerBase implements SensorManagerInterface {

    function create(Sensor $sensor) {
        $sensorEntity = $this->mapper->contractToEntity($sensor);
        try {
            $sensorEntity->save();
        } catch (IntegrityException $integrityException) {
            Yii::error($integrityException->getMessage());
            throw new ManagerException("Cannot create sensor", "", "", $integrityException);
        }

        return $sensor;
    }

    function retrieve(Limit $limit, SensorOrder $order) {
        // TODO: Implement retrieve() method.
    }

    function getById(Guid $id) {
        $entity = SensorEntity::findOne(['id', $id->toBinaryString()]);

        return $entity != null ? $this->mapper->entityToContract($entity) : null;
    }

    function update(Sensor $sensorVendor) {
        // TODO: Implement update() method.
    }

    function delete(Guid $id) {
        // TODO: Implement delete() method.
    }

    protected function initMapper() {
        return new SensorMapper();
    }
}