<?php

namespace app\utils\enum;

/**
 * Order direction enum
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\Enum
 */
final class OrderDirectionEnum extends EnumBase {

    const ASC  = 1;
    const DESC = 0;

    public function __construct($value = self::ASC) {
        $this->setValue($value);
    }

}
