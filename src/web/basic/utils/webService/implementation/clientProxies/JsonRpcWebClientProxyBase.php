<?php

namespace app\utils\webService\implementation\clientProxies;

use app\utils\exceptions\WebServiceFaultException;

use app\utils\webService\clientProxies\WebClientProxyBase;
use app\utils\webService\contracts\HttpAuthBase;
use app\utils\webService\contracts\services\HttpProxy;
use app\utils\webService\contracts\services\WebServiceEndpoint;
use yii\base\Exception;

abstract class JsonRpcWebClientProxyBase extends WebClientProxyBase {
    /**
     * @var BaseJsonRpcClient
     */
    private $_jsonRpcClient;

    protected function setRpcClientGeneratedProxy(BaseJsonRpcClient $generatedProxy) {
        $this->_jsonRpcClient = $generatedProxy;
    }

    protected function getRpcClientGeneratedProxy() {
        return $this->_jsonRpcClient;
    }

    public function setEndpoint(WebServiceEndpoint $endpoint) {
        parent::setEndpoint($endpoint);
        $this->setGeneratedProxy();
    }

    public function setHttpProxy(HttpProxy $proxy) {
        parent::setHttpProxy($proxy);
        $this->initHttpProxy();
    }

    public function setHttpAuth(HttpAuthBase $httpAuth) {
        parent::setHttpAuth($httpAuth);
        $this->initHttpAuth();
    }

    protected abstract function setGeneratedProxy();

    protected function dispatchCall($action) {
        try {
            /** @var $result BaseJsonRpcCall */
            $result = $action();
        } catch (Exception $exception) {
            throw new WebServiceFaultException($exception->getMessage(), null, $exception);
        }

        if (isset($result->Error)) {
            throw new WebServiceFaultException($result->Error['message'] . ' : ' . $result->Error['data'], $result->Error['code']);
        }
        return $result->Result;
    }

    private function initHttpProxy() {
        if ($this->httpProxy !== null) {
            $this->_jsonRpcClient->CurlOptions += array(
                CURLOPT_PROXY => $this->httpProxy->url,
                CURLOPT_PROXYUSERPWD => $this->httpProxy->login . ($this->httpProxy->password === null ? '' : ':' . $this->httpProxy->password)
            );
        }
    }

    private function initHttpAuth() {
        if ($this->httpAuth !== null) {
            $this->_jsonRpcClient->CurlOptions[CURLOPT_USERPWD] = $this->httpAuth->login . ($this->httpAuth->password === null ? '' : ':' . $this->httpAuth->password);

            if ($this->httpAuth instanceof HttpAuthDigest) {
                $this->_jsonRpcClient->CurlOptions[CURLOPT_HTTPAUTH] = CURLAUTH_DIGEST;
            }
        }
    }

}