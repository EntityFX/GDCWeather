<?php

namespace app\utils\webService\implementation\clientProxies\mapper;

use app\utils\exceptions\ManagerException;
use app\utils\mappers\BusinessLogicMapperBase;
use app\utils\webService\contracts\clientProxies\repositories\WebClientProxyData;
use app\utils\webService\contracts\services\enums\WebServiceTypeEnum;
use app\utils\webService\dataAccess\ClientProxyEntity;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class ClientProxyMapper extends BusinessLogicMapperBase {

    /**
     * @param \yii\base\Object $contract
     *
     * @return \yii\db\ActiveRecord
     */
    public function contractToEntity(\yii\base\Object $contract) {
        // TODO: Implement contractToEntity() method.
    }

    /**
     * @param \yii\db\ActiveRecord $contract
     *
     * @return \yii\base\Object
     */
    public function entityToContract(\yii\db\ActiveRecord $entity) {
        /** @var $contract ClientProxyEntity */
        if (!($entity instanceof ClientProxyEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }

        $object                    = new WebClientProxyData();
        $object->contractClassName = $entity->contract;
        $object->id                = $entity->id;
        $object->proxyType         = new WebServiceTypeEnum((int)$entity->type);

        return $object;
    }
}