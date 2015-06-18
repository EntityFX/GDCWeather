<?php

namespace app\utils\validators;

/**
 * Class IServiceValidator
 *
 * @author EntityFX
 */
interface ManagerValidatableInterface {

    const IS_VALID = 0;

    /**
     * @return int
     */
    function validate();
}