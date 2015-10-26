<?php

namespace app\utils\webService;

use app\utils\webService\contracts\clientProxies\repositories\WebClientProxyRepositoryInterface;
use app\utils\webService\contracts\clientProxies\WebClientProxyInterface;
use Traversable;
use yii\base\Exception;
use yii\di\Container;
use yii\di\ServiceLocator;

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
        $clientProxyRepository = self::getIoc()->get(
            'app\utils\webService\contracts\clientProxies\repositories\WebClientProxyRepositoryInterface'
        );
        $clientProxyData       = $clientProxyRepository->getById($id);
        if ($clientProxyData == null) {
            throw new Exception("Cannot find proxy, id $id");
        }

        $proxyList = [];

        foreach($clientProxyData->endpointList as $endpoint) {
            /** @var $webClientProxy WebClientProxyInterface */
            $webClientProxy = self::getIoc()->get($clientProxyData->contractClassName);
            $webClientProxy->setEndpoint($endpoint);
            $proxyList[] = $webClientProxy;
        }

        return $proxyList;
    }

    /**
     * @return Container
     */
    private static function getIoc() {
        //$diConfig = include('di.php');
        $diConfig = [];
        $container = new Container();
        $container->setSingleton(
            'clientProxyMapper', 'app\utils\webService\implementation\clientProxies\mapper\ClientProxyMapper'
        );
        $container->setSingleton(
            'app\utils\webService\contracts\clientProxies\repositories\WebClientProxyRepositoryInterface',
            function ($container, $params, $config) use ($diConfig) {
                return $container->get(
                    'app\utils\webService\implementation\clientProxies\repositories\WebClientProxyRepository',
                    [$container->get('clientProxyMapper')]
                );
            }
        );

        /*$container->set('app\utils\workers\contracts\WorkerInterceptorInterface',
            function($container, $params, $config) use ($diConfig) {
                return  $container->get(
                    $diConfig['workerInterceptor'],
                    [$params['worker'], $container->get('app\utils\workers\contracts\repositories\WorkerRepositoryInterface')]
                );
            });*/

        return $container;
    }
}