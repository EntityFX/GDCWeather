<?php

namespace app\utils\webService\implementation\services;

use app\utils\webService\contracts\services\enums\WebServiceTypeEnum;
use yii\base\Component;

/**
 * Class WebServiceBase
 *
 * @property WebServiceTypeEnum $serviceType
 */
abstract class WebServiceBase extends Component {
    /**
     * @var WebServiceTypeEnum
     */
    private $_serviceType;

    /**
     * @param WebServiceTypeEnum $serviceType
     */
    public function setServiceType(WebServiceTypeEnum $serviceType) {
        $this->_serviceType = $serviceType;
    }

    /**
     * @return WebServiceTypeEnum
     */
    public function getServiceType() {
        return $this->_serviceType;
    }
}