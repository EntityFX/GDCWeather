<?php

namespace app\utils\exceptions;

use yii\base\Exception;

abstract class InternalExceptionBase extends Exception {
    /**
     * @var Exception;
     */
    private $_internalException;

    public function __construct($message, Exception $internalException = null, $appendInternalExceptionMessage = false) {
        $this->_internalException = $internalException;
        if ($internalException!=null && $appendInternalExceptionMessage) {
            $internalExceptionClassName = get_class($internalException);
            $message .= "\r\nInternal Exception: {$internalExceptionClassName}. Message {$internalException->getMessage()}";
        }
        parent::__construct($message);
    }

    /**
     * @return Exception
     */
    public function getInternalException() {
        return $this->_internalException;
    }
}