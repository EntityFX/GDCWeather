<?php

namespace app\utils\validators;

use DateInterval;
use DateTime;

class StatePeriodValidatableInterface implements ManagerValidatableInterface {

    /**
     * Максимальный интевал аренды в формате DateTimeInterval
     */
    const STATUS_ALREADY_RENTED_MAX_INTERVAL = 'P11M';

    /**
     * Код ошибки: неверный период интервала
     */
    const FAULT_BAD_DATETIME_PERIOD = 2;

    /**
     * Код ошибки: неверная дата начала периода
     */
    const FAULT_BAD_START_DATETIME = 3;

    private $_beginDateTime;

    private $_endDateTime;

    public function __construct(DateTime $beginDateTime, DateTime $endDateTime) {
        $this->_beginDateTime = $beginDateTime;
        $this->_endDateTime = $endDateTime;
    }

    public function validate() {
        $todayDateTime = new DateTime('today');
        $maxDateTime = clone $todayDateTime;
        $isPeriodValid = $this->_endDateTime <= $maxDateTime->add(new DateInterval(self::STATUS_ALREADY_RENTED_MAX_INTERVAL));

        $isCurrentDateValid = $this->_beginDateTime >= $todayDateTime;

        if (!$isCurrentDateValid) {
            return self::FAULT_BAD_START_DATETIME;
        }

        if (!$isPeriodValid) {
            return self::FAULT_BAD_DATETIME_PERIOD;
        }

        return ManagerValidatableInterface::IS_VALID;
    }
}