<?php

namespace app\utils\exceptions;

use yii\base\Exception;

class WebServiceFaultException extends InternalExceptionBase {

    private $_faultContext = null;

    public function __construct($message, $faultContext = null, Exception $internalException = null) {
        $this->_faultContext = $faultContext;
        parent::__construct($message, $internalException, true);
    }
}