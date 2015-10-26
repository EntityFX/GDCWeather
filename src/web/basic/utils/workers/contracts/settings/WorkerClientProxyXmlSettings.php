<?php

namespace app\utils\workers\contracts\settings;
use SimpleXMLElement;
use app\utils\webService\HttpProxy;
use app\utils\webService\HttpAuthBase;
use app\utils\webService\HttpAuthBasic;
use app\utils\webService\HttpAuthDigest;
use app\utils\crypto\CryptoAlgorithmEnum;
use app\utils\crypto\CryptoFactory;
use yii\base\Exception;

/**
 * Class WorkerClientProxySettingsParser
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class WorkerClientProxyXmlSettings implements WorkerClientProxySettingsInterface {

    /**
     * @var SimpleXMLElement
     */
    private $_configXmlElement;

    /**
     * @var string
     */
    private $_httpAuthCryptoKey = '';

    /**
     * @var string
     */
    private $_httpProxyAuthCryptoKey = '';

    public function __construct(SimpleXMLElement $configXmlElement) {
        $this->_configXmlElement = $configXmlElement;
    }

    public function setHttpAuthCryptoKey($key) {
        $this->_httpAuthCryptoKey = (string)$key;
    }

    public function setHttpProxyAuthCryptoKey($key) {
        $this->_httpProxyAuthCryptoKey = (string)$key;
    }

    /**
     * @param $clientProxyId
     *
     * @return HttpProxy|null
     */
    public function getHttpProxyAuthConfig($clientProxyId) {
        /** @var $xmlConfigElement SimpleXMLElement */
        $xmlConfigElement = $this->getXmlConfigElementByClientProxyId($clientProxyId);
        if (isset($xmlConfigElement->httpProxyAuth)) {
            /** @var $httpProxyAuthElement SimpleXMLElement */
            $httpProxyAuthElement = $xmlConfigElement->httpProxyAuth;
            if (isset($httpProxyAuthElement->crypto)) {
                $keyValue = $this->_httpProxyAuthCryptoKey;
                $httpProxyAuthElement = $this->decryptOrDefault(
                    $httpProxyAuthElement->crypto->encryption,
                    $keyValue,
                    $httpProxyAuthElement->crypto->data,
                    new SimpleXMLElement('<httpProxyAuth></httpProxyAuth>')
                );
            }
            if (isset($httpProxyAuthElement->url)) {
                $httpProxy = new HttpProxy($httpProxyAuthElement->url);
                $httpProxy->login = $httpProxyAuthElement->login;
                $httpProxy->password = $httpProxyAuthElement->password;
                return $httpProxy;
            }
        }
        return null;
    }

    /**
     * @param $clientProxyId
     *
     * @return HttpAuthBase|null
     */
    public function getHttpAuthConfig($clientProxyId) {
        /** @var $xmlConfigElement SimpleXMLElement */
        $xmlConfigElement = $this->getXmlConfigElementByClientProxyId($clientProxyId);
        if (isset($xmlConfigElement->httpAuth)) {
            /** @var $httpAuthElement SimpleXMLElement */
            $httpAuthElement = $xmlConfigElement->httpAuth;
            if (isset($httpAuthElement->crypto)) {
                $keyValue = $this->_httpAuthCryptoKey;
                $httpAuthElement = $this->decryptOrDefault(
                    $httpAuthElement->crypto->encryption,
                    $keyValue,
                    $httpAuthElement->crypto->data,
                    new SimpleXMLElement('<httpAuth></httpAuth>')
                );
            }
            if (isset($httpAuthElement->credentials)) {
                $httpAuthCredentialsElement = $httpAuthElement->credentials;
                $httpAuthCredentialsType = $httpAuthCredentialsElement->attributes()->authType;
                if ($httpAuthCredentialsType == 'basic') {
                    $httpAuth = new HttpAuthBasic();
                } else if ($httpAuthCredentialsType == 'digest') {
                    $httpAuth = new HttpAuthDigest();
                }
                if ($httpAuth != null) {
                    $httpAuth->login = $httpAuthCredentialsElement->login;
                    $httpAuth->password = $httpAuthCredentialsElement->password;
                }
                return $httpAuth;
            }
        }
        return null;
    }

    private static function decryptOrDefault($algorithm, $key, $data, SimpleXMLElement $default = null) {
        if ($algorithm == 'xxtea') {
            $cryptoEnumValue = CryptoAlgorithmEnum::XXTEA;
        } else {
            $cryptoEnumValue = CryptoAlgorithmEnum::USE_DEFAULT;
        }
        $cryptoAlgorithm = CryptoFactory::create(new CryptoAlgorithmEnum($cryptoEnumValue));
        $decodedString = $cryptoAlgorithm->decrypt(base64_decode($data), $key);
        $result = $default;

        if ($decodedString !== false) {
            try {
                $result = new SimpleXMLElement($decodedString);
            } catch (Exception $exception) {
                $result = $default;
            }
        }

        return $result;
    }

    private function getXmlConfigElementByClientProxyId($clientProxyId) {
        $clientProxyConfigElement = $this->_configXmlElement->xpath("/worker/clientProxies/clientProxy[@id={$clientProxyId}]");
        return count($clientProxyConfigElement) > 0 ? $clientProxyConfigElement[0] : $this->getDefaultClientProxyXmlConfigElement();
    }

    private $_cachedDefaultClientProxyXmlConfigElement;

    private function getDefaultClientProxyXmlConfigElement() {
        if ($this->_cachedDefaultClientProxyXmlConfigElement === null) {
            $path = $this->_configXmlElement->xpath("/worker/clientProxies/clientProxy[@default]");
            if (count($path) > 0) {
                $this->_cachedDefaultClientProxyXmlConfigElement = $path[0];
            }
        }
        return $this->_cachedDefaultClientProxyXmlConfigElement;
    }
}