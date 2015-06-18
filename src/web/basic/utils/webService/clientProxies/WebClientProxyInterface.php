<?php

namespace app\utils\webService\clientProxies;

use app\utils\webService\WebServiceEndpoint;
use app\utils\webService\HttpProxy;
use app\utils\webService\HttpAuthBase;

/**
 * Class IWebClientProxy
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\WebClientProxy
 */
interface WebClientProxyInterface {
    /**
     * @return WebServiceEndpoint
     */
    public function getEndpoint();

    public function setEndpoint(WebServiceEndpoint $endpointList);

    public function setHttpProxy(HttpProxy $proxy);

    public function getHttpProxy();

    public function setHttpAuth(HttpAuthBase $httpAuth);

    public function getHttpAuth();
}