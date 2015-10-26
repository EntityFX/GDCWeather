<?php

namespace app\utils\webService\contracts\services\enums;
use app\utils\enum\EnumBase;

/**
 * Перечисление типой веб-сервисов
 *
 * @author  EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\WebService
 */
class WebServiceTypeEnum extends EnumBase {
    const OTHER     = 0;
    const SOAP      = 1;
    const REST      = 2;
    const JSON_RPC  = 3;
    const POST_FILE = 4;
}