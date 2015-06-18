<?php

namespace app\utils\logging;
use app\utils\ModelKeyBase;
use DateTime;

/**
 * Class LoggingFilter
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property DateTime            $dateTime
 * @property LoggingSeverityEnum $severity
 * @property string              $category
 * @property string              $message
 */
class LoggingData extends ModelKeyBase {

    /**
     * @var DateTime
     */
    private $_dateTime;
    /**
     * @var LoggingSeverityEnum
     */
    private $_severity;
    /**
     * @var string
     */
    private $_category;

    /**
     * @var string
     */
    private $_message;

    /**
     * @return string
     */
    public function getCategory() {
        return $this->_category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category = null) {
        $this->_category = $category === null ? null : (string)$category;
    }

    /**
     * @return DateTime
     */
    public function getDateTime() {
        return $this->_dateTime;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setDateTime(DateTime $dateTime = null) {
        $this->_dateTime = $dateTime;
    }

    /**
     * @param string $message
     */
    public function setMessage($message) {
        $this->_message = (string)$message;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->_message;
    }

    /**
     * @return LoggingSeverityEnum
     */
    public function getSeverity() {
        return $this->_severity;
    }

    /**
     * @param LoggingSeverityEnum $severity
     */
    public function setSeverity(LoggingSeverityEnum $severity = null) {
        $this->_severity = $severity;
    }
}