<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\businessLogic\contracts\sensor;


use app\businessLogic\contracts\sensor\enums\SensorTypeEnum;
use app\utils\Guid;
use yii\base\Object;

class Sensor extends Object {
    /**
     * @var Guid
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_model;

    /**
     * @var SensorTypeEnum
     */
    private $_type;

    public function __construct() {
        parent::__construct();
        $this->_id = Guid::generate();
    }

    /**
     * @return Guid
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @param Guid $id
     */
    public function setId($id) {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getModel() {
        return $this->_model;
    }

    /**
     * @param string $model
     */
    public function setModel($model) {
        $this->_model = $model;
    }

    /**
     * @return SensorTypeEnum
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * @param SensorTypeEnum $type
     */
    public function setType(SensorTypeEnum $type) {
        $this->_type = $type;
    }

    /**
     * @return SensorVendor
     */
    public function getVendor() {
        return $this->_vendor;
    }

    /**
     * @param SensorVendor $vendor
     */
    public function setVendor(SensorVendor $vendor) {
        $this->_vendor = $vendor;
    }

    /**
     * @var SensorVendor
     */
    private $_vendor;
}