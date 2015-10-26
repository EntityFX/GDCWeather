<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\utils\webService\implementation\clientProxies\mapper;


use app\utils\exceptions\ManagerException;
use app\utils\mappers\BusinessLogicMapperBase;
use app\utils\webService\contracts\services\WebServiceEndpoint;
use app\utils\webService\dataAccess\ClientProxyEndpointEntity;

class ClientProxyEndpointMapper extends BusinessLogicMapperBase {

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
        /** @var $contract ClientProxyEndpointEntity */
        if (!($entity instanceof ClientProxyEndpointEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }

        $object          = new WebServiceEndpoint();
        $object->baseUrl = $entity->url;
        $object->id      = $entity->id;
        $object->version = $entity->version;

        return $object;
    }
}