<?php

namespace app\utils\webService\implementation\clientProxies;

use app\utils\webService\contracts\clientProxies\WebClientProxyInterface;
use app\utils\webService\contracts\HttpAuthBase;
use app\utils\webService\contracts\services\HttpProxy;
use app\utils\webService\contracts\services\WebServiceEndpoint;
use yii\base\Component;


/**
 * Class WebClientProxyBase
 *
 * @author  EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\WebClientProxy
 * @property HttpProxy $httpProxy
 * @property HttpAuthBase $httpAuth
 */
abstract class WebClientProxyBase extends Component implements WebClientProxyInterface {
    /**
     * @var WebServiceEndpoint
     */
    private $_endpoint;

    /**
     * @var HttpProxy
     */
    private $_httpProxy;

    /**
     * @var HttpAuthBase
     */
    private $_httpAuth;

    /**
     * @return WebServiceEndpoint
     */
    public function getEndpoint() {
        return $this->_endpoint;
    }

    public function setEndpoint(WebServiceEndpoint $endpoint) {
        $this->_endpoint = $endpoint;
    }

    public function setHttpProxy(HttpProxy $proxy) {
        $this->_httpProxy = $proxy;
    }

    public function getHttpProxy() {
        return $this->_httpProxy;
    }

    public function setHttpAuth(HttpAuthBase $httpAuth) {
        $this->_httpAuth = $httpAuth;
    }

    public function getHttpAuth() {
        return $this->_httpAuth;
    }

}