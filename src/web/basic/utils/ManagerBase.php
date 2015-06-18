<?php

namespace app\utils;
use yii\di\ServiceLocator;

/**
 * Description of Services
 *
 * @author EntityFX
 * @package Kontinent\Components\Common
 */
abstract class ManagerBase extends ComponentBase
{

    const SERVICE_CATEGORY    = 'application.components.services';
    const FAULT_BAD_OPERATION = 111;

    public function __construct() {

    }
}