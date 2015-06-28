<?php

namespace app\utils\workers;

use app\utils\webService\clientProxies\WebClientProxyInterface;
use Traversable;

interface WorkerWithProxiesInterface {
    /**
     * @return WebClientProxyInterface[]|Traversable
     */
    public function getWebClientProxyList();

    public function setWebClientProxyList(Traversable $proxyList);
}