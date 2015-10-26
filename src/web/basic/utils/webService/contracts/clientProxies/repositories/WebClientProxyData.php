<?php

namespace app\utils\webService\contracts\clientProxies\repositories;

use app\utils\webService\contracts\services\enums\WebServiceTypeEnum;
use app\utils\webService\contracts\services\WebServiceEndpoint;
use Traversable;
use yii\base\Component;

/**
 * Class WebClientProxyData
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 *
 * @property string                         $contractClassName Класс или Интерфейс - контракт клиена
 * @property WebServiceEndpoint[]|Traversable $endpointList      Список конечных точек сервисов
 * @property WebServiceTypeEnum         $proxyType         Тип сервиса, которм являетяс клиент
 * @property int                            $id                ID
 * @package Kontinent\Components\Common\WebClientProxy
 */
class WebClientProxyData extends Component {

    /**
     * @var int
     */
    private $_id;

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->_id = (int)$id;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @var WebServiceEndpoint[]
     */
    private $_endpointList = [];
    /**
     * @var string
     */
    private $_contractClassName;
    /**
     * @var WebServiceTypeEnum
     */
    private $_proxyType;

    /**
     * @return string
     */
    public function getContractClassName() {
        return $this->_contractClassName;
    }

    /**
     * @param string $contractClassName
     */
    public function setContractClassName($contractClassName) {
        $this->_contractClassName = (string)$contractClassName;
    }

    public function getEndpointList() {
        return $this->_endpointList;
    }

    public function setEndpointList(array $endpointList) {
        $this->_endpointList = $endpointList;
    }

    /**
     * @return WebServiceTypeEnum
     */
    public function getProxyType() {
        return $this->_proxyType;
    }

    /**
     * @param WebServiceTypeEnum $proxyType
     */
    public function setProxyType(WebServiceTypeEnum $proxyType) {
        $this->_proxyType = $proxyType;
    }
}