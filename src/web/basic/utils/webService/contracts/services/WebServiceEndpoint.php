<?php

namespace app\utils\webService\contracts\services;
;
use yii\base\Component;

/**
 * Class WebClientProxyEndpoint
 *
 * @author  EntityFX <artem.solopiy@gmail.com>
 * @property string $baseUrl Адрес конечной точки
 * @property string $version Версия конечной точки
 * @property int    $id      ID конечной точки
 * @package Kontinent\Components\Common\WebService
 */
class WebServiceEndpoint extends Component {

    /**
     * @var int
     */
    private $_id;
    /**
     * @var string
     */
    private $_baseUrl;
    /**
     * @var string
     */
    private $_version;

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = (int)$id;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->_version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version) {
        $this->_version = (string)$version;
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->_baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl) {
        $this->_baseUrl = (string)$baseUrl;
    }
}