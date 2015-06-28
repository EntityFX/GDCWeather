<?php

namespace app\utils\ioc;

use Yii;

abstract class IocComponentBase extends \yii\base\Component implements IIocComponent {
    protected $container;

    public function init() {
        if (Yii::getAlias(IIocComponent::COMPONENT_NAME) === false)
            Yii::setAlias(IIocComponent::COMPONENT_NAME, realpath(dirname(__FILE__) . '/..'));
    }

    public function getContainer() {
        return $this->container;
    }
}