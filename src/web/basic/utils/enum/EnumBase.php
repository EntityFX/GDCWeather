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

    protected $__value;
    private $__isNullable = false;
    private $__checked = false;

    public function __construct($value, $nullable = false) {
        $this->__value = $value;
        $this->__isNullable = $nullable;
        if (!$this->check()) {
            throw new Exception("Constant $value is missing in " . get_class($this));
        }
    }

    public function check() {
        if ($this->__isNullable && $this->__value === null) {
            return true;
        }
        $reflector = new ReflectionClass($this);
        $consts = $reflector->getConstants();
        foreach ($consts as $constValue) {
            if ($this->__value === $constValue) {
                return true;
            }
        }
        $this->__checked = true;
        return false;
    }

    public function getValue() {
        return $this->__value;
    }

    public function getArray() {
        $reflector = new ReflectionClass($this);
        return $reflector->getConstants();
    }

}