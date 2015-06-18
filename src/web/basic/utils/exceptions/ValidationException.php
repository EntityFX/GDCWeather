<?php

namespace app\utils\exceptions;
use yii\base\Exception;

/**
 * Исключение ошибок валидации
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\Exceptions
 */
class ValidationException extends InternalExceptionBase {
    private $_faultCode;

    public function __construct($message, $faultCode = null, Exception $internalException = null) {
        $this->_faultCode = (int)$faultCode;
        parent::__construct($message, $internalException);
    }

    public function getFaultCode() {
        return $this->_faultCode;
    }
}