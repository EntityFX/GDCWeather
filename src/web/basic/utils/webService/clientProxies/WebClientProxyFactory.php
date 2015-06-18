<?php

namespace app\utils\webService\clientProxies;
use app\utils\webService\clientProxies\repositories\WebClientProxyRepositoryInterface;
use Traversable;
use yii\base\Exception;

/**
 * Class WebClientProxyFactory
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class WebClientProxyFactory {
    /**
     * @param int $id
     *
     * return IWebClientProxy
     *
     * @return WebClientProxyInterface[]|Traversable
     * @throws Exception
     */
    public static function create($id) {
        /** @var $clientProxyRepository WebClientProxyRepositoryInterface */
        $clientProxyRepository = self::getIoc()->create('IWebClientProxyRepository');
        $clientProxyData = $clientProxyRepository->getProxy($id);
        if ($clientProxyData == null) {
            throw new Exception("Cannot find proxy, id $id");
        }

        $proxyList = new \ArrayObject();

        foreach($clientProxyData->endpointList as $endpoint) {
            /** @var $webClientProxy WebClientProxyInterface */
            $webClientProxy = self::getIoc()->create($clientProxyData->contractClassName);
            $webClientProxy->setEndpoint($endpoint);
            $proxyList[] = $webClientProxy;
        }



        return $proxyList;
    }

    /**
     * @return Phemto
     */
    private static function getIoc() {
        return Yii::app()->ioc->container;
    }
}