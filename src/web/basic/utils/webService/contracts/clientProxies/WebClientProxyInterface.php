<?php

namespace app\utils\webService\contracts\clientProxies;

use app\utils\webService\contracts\HttpAuthBase;
use app\utils\webService\contracts\services\HttpProxy;
use app\utils\webService\contracts\services\WebServiceEndpoint;


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