<?php
namespace app\utils\helpers;

use DateTime;
use yii\base\Component;

/**
 * Class DateTimePeriodHelper
 * @property DateTime $dateTimeFrom
 * @property DateTime $dateTimeTo
 * @property string $dateTimePeriod
 */
class DateTimePeriodHelper extends Component {

    /**
     * @var string
     */
    private $_separator = '-';
    /**
     * @var DateTime
     */
    private $_dateTimeFrom;
    /**
     * @var DateTime
     */
    private $_dateTimeTo;
    /**
     * @var bool
     */
    private $_isStatusDateParsed = false;
    /**
     * @var bool
     */
    private $_isStatusRangeParsed = false;
    /**
     * @var string
     */
    private $_datetimePeriod;
    /**
     * @var $dateFormat
     */
    private $_dateFormat;

    /**
     * Отображать только дату
     *
     * @var bool
     */
    private $_dateOnly;

    public function __construct($dateFormat = "medium", $dateOnly = true, $separator = '-') {
        $this->_dateFormat = (string)$dateFormat;
        $this->_separator  = $separator == '' ? '-' : (string)$separator[0];
        $this->_dateOnly = (bool)$dateOnly;
    }

    public function validate() {
        try {
            $this->parseDateTimePeriod();
            return true;
        }
        catch (ValidationException $exception){
            return false;
        }
    }

    /**
     * @return DateTime
     */
    public function getDateTimeFrom() {
        $this->parseDateTimePeriod();

        return $this->_dateTimeFrom;
    }

    /**
     * @param DateTime $value
     */
    public function setDateTimeFrom(DateTime $value = null) {
        $this->_dateTimeFrom        = $value;
        $this->_isStatusRangeParsed = false;
    }

    /**
     * parses datetime string to Datetime objects
     */
    private function parseDateTimePeriod() {
        if ($this->_isStatusDateParsed || trim($this->_datetimePeriod) === '') {
            return;
        }

        $dateRangeArray = explode($this->_separator, $this->_datetimePeriod);

        foreach ($dateRangeArray as $dateKey => $dateValue) {
            $dateRangeArray[$dateKey] = trim($dateValue);
        }

        list
            (
            $statusDateFromString,
            $statusDateToString
            )
            = $dateRangeArray;


        //CVarDumper::dump(DateTimeHelper::parseDate($statusDateFromString), 10, true);
        if ($this->_dateOnly) {
            $this->_dateTimeFrom = DateTimeHelper::parseDate($statusDateFromString, $this->_dateFormat);
            $this->_dateTimeTo = DateTimeHelper::parseDate($statusDateToString, $this->_dateFormat);
            if ($this->_dateTimeTo !== false) {
                $this->_dateTimeTo->setTime(23, 59, 59);
            }
        } else {
            $this->_dateTimeFrom = DateTimeHelper::parseDateTime($statusDateFromString, $this->_dateFormat);
            $this->_dateTimeTo = DateTimeHelper::parseDateTime($statusDateToString, $this->_dateFormat);
        }

        if (!$this->_dateTimeTo || !$this->_dateTimeFrom) {
            throw new ValidationException(Yii::t('global', 'Неверное значение периода времени'));
        }

        $this->_isStatusDateParsed = true;
    }

    /**
     * @return DateTime
     */
    public function getDateTimeTo() {
        $this->parseDateTimePeriod();

        return $this->_dateTimeTo;
    }

    /**
     * @param DateTime $value
     */
    public function setDateTimeTo(DateTime $value = null) {

        $this->_dateTimeTo          = $value;
        $this->_isStatusRangeParsed = false;
    }

    /**
     * @return string
     */
    public function getDatetimePeriod() {
        if (!$this->_isStatusRangeParsed && $this->_dateTimeFrom != false && $this->_dateTimeTo != false) {
            if ($this->_dateOnly) {
                $fromPeriod = DateTimeHelper::format($this->_dateTimeFrom, DateTimeHelper::getDateFormat($this->_dateFormat));
                $toPeriod = DateTimeHelper::format($this->_dateTimeTo, DateTimeHelper::getDateFormat($this->_dateFormat));
            } else {
                $fromPeriod = DateTimeHelper::format($this->_dateTimeFrom, DateTimeHelper::getDateTimeFormat($this->_dateFormat));
                $toPeriod = DateTimeHelper::format($this->_dateTimeTo, DateTimeHelper::getDateTimeFormat($this->_dateFormat));
            }
            $this->_datetimePeriod = $fromPeriod . ' ' . $this->_separator . ' ' . $toPeriod;
            $this->_isStatusRangeParsed = true;
        }

        return $this->_datetimePeriod;
    }

    /**
     * @param string $value
     */
    public function setDatetimePeriod($value) {
        $this->_datetimePeriod = (string)$value;
    }
}