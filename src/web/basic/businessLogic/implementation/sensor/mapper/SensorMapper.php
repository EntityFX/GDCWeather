<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\businessLogic\implementation\sensor\mapper;

use app\businessLogic\contracts\sensor\Sensor;
use app\utils\exceptions\ManagerException;
use app\utils\mappers\BusinessLogicMapperBase;
use yii\base\Object;
use yii\db\ActiveRecord;
use app\dataAccess\entities\SensorEntity;

class SensorMapper extends BusinessLogicMapperBase {

    /**
     * @param \yii\base\Object $contract
     *
     * @return ActiveRecord
     */
    public function contractToEntity(Object $contract) {
        /** @var $contract Sensor */
        if (!($contract instanceof Sensor)) {
            throw new ManagerException("Wrong type of mapping contract");
        }
        $entity           = new SensorEntity();
        $entity->id       = $contract->id->toBinaryString();
        $entity->name     = $contract->name;
        $entity->model    = $contract->model;
        $entity->type     = (int)$contract->type->getValue();
        $entity->vendorId = $contract->vendor->id->toBinaryString();

        return $entity;
    }

    /**
     * @param ActiveRecord $contract
     *
     * @return \yii\base\Object
     */
    public function entityToContract(ActiveRecord $entity) {
        /** @var $entity SensorEntity */
        if (!($entity instanceof SensorEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }
        $sensor       = new SensorVendor();
        $vendor->id   = Guid::parseBinaryString($entity->id);

        $vendor->name = $entity->name;

        return $vendor;
    }
}