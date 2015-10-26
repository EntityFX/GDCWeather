<?php

namespace app\utils\workers\contracts\enums;
use app\utils\enum\EnumBase;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class WorkerEventStatusEnum extends EnumBase {
    const EVENT_ON_BEGIN_RUN = 0;
    const EVENT_ON_END_RUN   = 1;
    const EVENT_ON_FAILED    = 2;
}