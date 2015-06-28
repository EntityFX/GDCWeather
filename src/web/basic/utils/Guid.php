<?php

namespace app\utils;
use yii\base\Component;
use app\utils\exceptions\ValidationException;

/**
 * class Guid
 * @property-read string $value Возвращает строковое значение без фигурных скобок
 */
class Guid extends Component {

    const GUID_REGEXP = "/^\{?[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}\}?$/i";

    /**
     * 
     * @access private
     * @var string
     */
    private $_value;

    public function __construct($value) {
        if (preg_match(self::GUID_REGEXP, $value)) {
            $this->_value = str_replace(array('{', '}'), "", $value);
        } else {
            throw new ValidationException('Error creating guid');
        }
    }

    public function __toString() {
        return '{' . $this->_value . '}';
    }
    
    public function getValue() {
        return $this->_value;
    }

}