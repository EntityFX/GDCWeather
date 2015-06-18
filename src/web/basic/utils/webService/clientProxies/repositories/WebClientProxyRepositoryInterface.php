<?php

namespace app\utils\webService\clientProxies\repositories;

use app\utils\Limit;
use Traversable;

interface WebClientProxyRepositoryInterface {
    /**
     * @param int $proxyId Идентификатор прокси
     *
     * @return WebClientProxyData
     */
    public function getProxy($proxyId);

    /**
     * @param Limit $limit
     *
     * @return WebClientProxyData[]|Traversable
     */
    public function getAll(Limit $limit);
}