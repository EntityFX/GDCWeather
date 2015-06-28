<?php

namespace app\utils\exceptions;
use yii\base\Exception;

/**
 * Class WorkerException
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class WorkerException extends InternalExceptionBase {
    private $_faultCode;

    /**
     * @var Exception
     */
    private $_internalException;

    public function __construct($message, $faultCode = null, Exception $internalException = null) {
        $this->_faultCode = (int)$faultCode;
        $this->_internalException = $internalException;
        parent::__construct($message, $internalException);
    }

    public function getFaultCode() {
        return $this->_faultCode;
    }

    public function getInternalException() {
        return $this->_internalException;
    }
}