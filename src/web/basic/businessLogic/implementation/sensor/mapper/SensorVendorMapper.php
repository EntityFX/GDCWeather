<?php
namespace app\businessLogic\implementation\sensor\mapper;

use app\businessLogic\contracts\sensor\SensorVendor;
use app\dataAccess\entities\SensorVendorEntity;
use app\utils\exceptions\ManagerException;
use app\utils\Guid;
use app\utils\mappers\BusinessLogicMapperBase;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class SensorVendorMapper extends BusinessLogicMapperBase {

    /**
     * @param \yii\base\Object $contract
     *
     * @return \yii\db\ActiveRecord
     */
    public function contractToEntity(\yii\base\Object $contract) {
        /** @var $contract SensorVendor */
        if (!($contract instanceof SensorVendor)) {
            throw new ManagerException("Wrong type of mapping contract");
        }
        $entity       = new SensorVendorEntity();
        $entity->id   = $contract->id->toBinaryString();
        $entity->name = $contract->name;

        return $entity;
    }

    /**
     * @param \yii\db\ActiveRecord $entity
     * @return \yii\base\Object
     * @internal param $contract
     *
     */
    public function entityToContract(\yii\db\ActiveRecord $entity) {
        /** @var $entity SensorVendorEntity */
        if (!($entity instanceof SensorVendorEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }
        $vendor       = new SensorVendor();
        $vendor->id   = Guid::parseBinaryString($entity->id);
        $vendor->name = $entity->name;

        return $vendor;
    }
}