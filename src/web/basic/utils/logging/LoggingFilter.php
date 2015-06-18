<?php

namespace app\utils\logging;
use DateTime;
use app\utils\filters\DefaultFilterInterface;
use app\utils\filters\OrdinaryFilterBase;

/**
 * Class LoggingFilter
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property DateTime            $dateTimeFrom
 * @property DateTime            $dateTimeTo
 * @property LoggingSeverityEnum $severity
 * @property string              $severityValue
 * @property string              $category
 */
class LoggingFilter extends OrdinaryFilterBase {

    /**
     * @var DateTime
     */
    private $_dateTimeFrom;
    /**
     * @var DateTime
     */
    private $_dateTimeTo;
    /**
     * @var LoggingSeverityEnum
     */
    private $_severity;
    /**
     * @var string
     */
    private $_category;

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
    public function getDateTimeFrom() {
        return $this->_dateTimeFrom;
    }

    /**
     * @param DateTime $dateTimeFrom
     */
    public function setDateTimeFrom(DateTime $dateTimeFrom = null) {
        $this->_dateTimeFrom = $dateTimeFrom;
    }

    /**
     * @return DateTime
     */
    public function getDateTimeTo() {
        return $this->_dateTimeTo;
    }

    /**
     * @param DateTime $dateTimeTo
     */
    public function setDateTimeTo(DateTime $dateTimeTo = null) {
        $this->_dateTimeTo = $dateTimeTo;
    }

    /**
     * @return LoggingSeverityEnum
     */
    public function getSeverity() {
        return $this->_severity;
    }

    /**
     * @return LoggingSeverityEnum
     */
    public function getSeverityValue() {
        if ($this->severity !== null) {
            switch($this->severity->getValue()) {
                case LoggingSeverityEnum::LEVEL_ERROR :
                    return 'error';
                case LoggingSeverityEnum::LEVEL_INFO :
                    return 'info';
                case LoggingSeverityEnum::LEVEL_PROFILE :
                    return 'profile';
                case LoggingSeverityEnum::LEVEL_TRACE :
                    return 'trace';
                case LoggingSeverityEnum::LEVEL_WARNING :
                    return 'warning';
            }
        }
        return null;
    }

    /**
     * @param LoggingSeverityEnum $severity
     */
    public function setSeverity(LoggingSeverityEnum $severity = null) {
        $this->_severity = $severity;
    }

    function setDefault() {
        $this->_category = "application.*";
        $this->_severity = null;
        $this->_dateTimeFrom = null;
        $this->_dateTimeTo = null;
    }

    function isFilterEmpty() {
        return ($this->_category = '' || $this->_category === null) &&
        $this->_severity === null &&
        $this->_dateTimeFrom === null &&
        $this->_dateTimeTo === null;
    }
}