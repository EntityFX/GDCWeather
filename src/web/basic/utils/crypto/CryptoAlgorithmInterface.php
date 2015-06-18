<?php

namespace app\utils\crypto;

/**
 * Class ICryptoAlgorithm
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
interface CryptoAlgorithmInterface {
    public function encrypt($data, $key);

    public function decrypt($data, $key);
}