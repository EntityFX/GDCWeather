<?php

namespace app\utils\webService\contracts\clientProxies\repositories;

use app\utils\Limit;
use Traversable;

interface WebClientProxyRepositoryInterface {
    /**
     * @param int $proxyId Идентификатор прокси
     *
     * @return WebClientProxyData
     */
    public function getById($proxyId);

    /**
     * @param Limit $limit
     *
     * @return ClientProxyDataRetrieveResult
     */
    public function getAll(Limit $limit);
}