<?php

namespace app\utils\webService\clientProxies;
use yii\base\Component;
use app\utils\webService\WebServiceEndpoint;
use app\utils\webService\HttpProxy;
use app\utils\webService\HttpAuthBase;

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