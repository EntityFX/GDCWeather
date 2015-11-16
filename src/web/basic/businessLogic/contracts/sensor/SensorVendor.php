<?php
namespace app\businessLogic\contracts\sensor;

use entityfx\utils\Guid;
use yii\base\Object;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class SensorVendor extends Object {
    /**
     * @var \entityfx\utils\Guid
     */
    private $_id;

    /**
     * @var string
     */
    private $_name;

    /**
     * SensorVendor constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->_id = Guid::generate();
    }

    /**
     * @return \entityfx\utils\Guid
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * @param \entityfx\utils\Guid $id
     */
    public function setId(Guid $id) {
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
}