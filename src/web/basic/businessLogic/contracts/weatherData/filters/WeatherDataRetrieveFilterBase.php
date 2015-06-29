<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.06.15
 * Time: 20:14
 */

namespace app\businessLogic\contracts\weatherData\filters;

use app\businessLogic\contracts\weatherData\enums\WeatherDataFilterTypeEnum;
use yii\base\Object;

/**
 * Class WeatherDataRetrieveFilterBase
 *
 * @package app\businessLogic\contracts\weatherData\filters
 *
 * @property \app\businessLogic\contracts\weatherData\enums\WeatherDataFilterTypeEnum $filterType
 */
abstract class WeatherDataRetrieveFilterBase extends Object {

    /**
     * @var \app\businessLogic\contracts\weatherData\enums\WeatherDataFilterTypeEnum
     */
    private $_filterType;

    function __construct() {
        $this->_filterType = $this->initFilterType();
    }

    /**
     * @return WeatherDataFilterTypeEnum
     */
    protected abstract function initFilterType();

    public function getFilterType() {
        return $this->_filterType;
    }
}