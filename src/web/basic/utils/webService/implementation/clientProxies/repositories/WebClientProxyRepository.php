<?php
namespace app\utils\webService\implementation\clientProxies\repositories;

use app\utils\Limit;
use app\utils\mappers\BusinessLogicMapperBase;
use app\utils\RepositoryBase;
use app\utils\webService\contracts\clientProxies\repositories\ClientProxyDataRetrieveResult;
use app\utils\webService\contracts\clientProxies\repositories\WebClientProxyData;
use app\utils\webService\contracts\clientProxies\repositories\WebClientProxyRepositoryInterface;
use app\utils\webService\dataAccess\ClientProxyEntity;
use app\utils\webService\implementation\clientProxies\mapper\ClientProxyEndpointMapper;
use app\utils\webService\implementation\clientProxies\mapper\ClientProxyMapper;
use Traversable;
use yii\db\Query;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class WebClientProxyRepository extends RepositoryBase implements WebClientProxyRepositoryInterface {

    /**
     * @var ClientProxyMapper
     */
    private $_mapper;
    /**
     * @var ClientProxyEndpointMapper
     */
    private $_endpointMapper;

    public function __construct(BusinessLogicMapperBase $mapper, ClientProxyEndpointMapper $endpointMapper) {
        parent::__construct();
        $this->_mapper         = $mapper;
        $this->_endpointMapper = $endpointMapper;
    }

    /**
     * @param int $proxyId Идентификатор прокси
     *
     * @return WebClientProxyData
     */
    public function getById($proxyId) {

        $entity = ClientProxyEntity::find()
                                   ->with('endpoints')
                                   ->where(['id' => $proxyId])
                                   ->one();

        $result = $entity != null ? $this->_mapper->entityToContract($entity) : null;

        $endpointList = [];
        foreach ($entity->endpoints as $endpointEntityItem) {
            $endpointList[] = $this->_endpointMapper->entityToContract($endpointEntityItem);
        }
        $result->endpointList = $endpointList;

        return $result;
    }

    /**
     * @param Limit $limit
     *
     * @return ClientProxyDataRetrieveResult|Traversable
     */
    public function getAll(Limit $limit) {
        $retrieveResult = new ClientProxyDataRetrieveResult();

        $retrieveQuery = ClientProxyEntity::find();

        $countQuery                 = $retrieveQuery->prepare(new Query());
        $retrieveResult->totalItems = $countQuery->count();


        $items = ClientProxyEntity::find()
                                  ->with('endpoints')
                                  ->limit($limit->getSize())
                                  ->offset($limit->getOffset())
                                  ->all();

        $clientProxies = [];
        foreach ($items as $item) {
            $clientProxy  = $this->_mapper->entityToContract($item);
            $endpointList = [];
            foreach ($item->endpoints as $endpointEntityItem) {
                $endpointList[] = $this->_endpointMapper->entityToContract($endpointEntityItem);
            }
            $clientProxy->endpointList = $endpointList;
            $clientProxies[]           = $clientProxy;
        }

        $retrieveResult->dataItems = $clientProxies;

        return $retrieveResult;

    }
}