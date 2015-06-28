<?php

namespace app\utils\exceptions;
use yii\base\Exception;

/**
 * Исключения ошибок бизнес-логики в сервисах
 *
 * @author EntityFX
 * @package Kontinent\Components\Common\Exceptions
 */
class ManagerException extends InternalExceptionBase {
    
    private $_category;

    private $_faultCode;
    
    public function __construct($message, $category = "", $faultCode = null, Exception $internalException = null) {
        $this->_category = (string)$category;
        $this->_faultCode = (int)$faultCode;
        parent::__construct($message, $internalException);
    }
    
    public function getCategory(){
        return $this->_category;
    }

    public function getFaultCode(){
        return $this->_faultCode;
    }
}