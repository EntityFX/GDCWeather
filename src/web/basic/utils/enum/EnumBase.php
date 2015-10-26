<?php

namespace app\utils\enum;
use Exception;
use ReflectionClass;

/**
 * Class EnumBase
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\Enum
 */
abstract class EnumBase {

    private $_value;
    private $_isNullable = false;
    private $_checked = false;

    public function __construct($value, $nullable = false) {
        $this->_isNullable = $nullable;
        $this->setValue($value);
        if (!$this->check()) {
            throw new Exception("Constant $value is missing in " . static::class);
        }
    }

    public function check() {
        if ($this->_isNullable && $this->_value === null) {
            return true;
        }
        $reflector = new ReflectionClass($this);
        $consts = $reflector->getConstants();
        foreach ($consts as $constValue) {
            if ($this->_value === $constValue) {
                return true;
            }
        }
        $this->_checked = true;
        return false;
    }

    public function getValue() {
        return $this->_value;
    }

    protected function setValue($value) {
        $this->_value = (int)$value;
    }

    public function getArray() {
        $reflector = new ReflectionClass($this);
        return $reflector->getConstants();
    }

    public function __toString() {
        $reflector = new ReflectionClass($this);
        $consts    = $reflector->getConstants();
        $constName = array_search($this->_value, $consts, true);

        return $constName === false ? static::class : static::class . '::' . $constName;
    }

}