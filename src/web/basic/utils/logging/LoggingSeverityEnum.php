<?php

namespace app\utils\logging;
use app\utils\enum\EnumBase;

/**
 * Class LoggingSeverityEnum
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class LoggingSeverityEnum extends EnumBase {
    const LEVEL_TRACE   = 0;
    const LEVEL_WARNING = 1;
    const LEVEL_ERROR   = 2;
    const LEVEL_INFO    = 3;
    const LEVEL_PROFILE = 4;
}