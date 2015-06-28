<?php

namespace app\utils\validators;
use DateTime;

/**
 * Class TodayDateTimeValidator
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class NowDateTimeValidatableInterface implements ManagerValidatableInterface {

    /**
     * Код ошибки: дата меньше сегодняшней
     */
    const FAULT_BAD_DATETIME = 2;

    /**
     * @var DateTime
     */
    private $_currentDateTime;

    public function __construct(DateTime $currentDateTime) {
        $this->_currentDateTime = $currentDateTime;
    }
    /**
     * @return int
     */
    function validate() {
        $todayDateTime = new DateTime('now');
        return $this->_currentDateTime >= $todayDateTime ? ManagerValidatableInterface::IS_VALID : self::FAULT_BAD_DATETIME;
    }
}