<?php

namespace app\utils\enum;

/**
 * Order direction enum
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common\Enum
 */
final class OrderDirectionEnum extends EnumBase {

    const ASC = "ASC";
    const DESC = "DESC";

    public function __construct($value = self::ASC) {
        $this->__value = $value;
    }

}
