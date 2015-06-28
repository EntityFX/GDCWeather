<?php

namespace app\utils\processes;
use app\utils\enum\EnumBase;

/**
 * Class ProcessOsTypeEnum
 */
final class ProcessOsTypeEnum extends EnumBase {
    const WINDOWS = 0;
    const LINUX = 1;
    const MAC_OS_X = 2;
    const OTHER = 99;
}