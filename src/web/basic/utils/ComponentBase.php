<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.06.15
 * Time: 22:26
 */

namespace app\utils;


use yii\base\Component;
use yii\di\ServiceLocator;

class ComponentBase extends Component {

    /**
     * ioc container
     *
     * @var ServiceLocator
     */
    protected $ioc;
}