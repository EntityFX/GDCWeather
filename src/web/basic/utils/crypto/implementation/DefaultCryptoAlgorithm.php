<?php

namespace app\utils\crypto\implementation;

use app\utils\crypto\contracts\DefaultCryptoAlgorithmInterface;
use app\utils\crypto\CryptoAlgorithmInterface;

class DefaultCryptoAlgorithm implements CryptoAlgorithmInterface, DefaultCryptoAlgorithmInterface {

    public function encrypt($data, $key) {
        // TODO: Implement encrypt() method.
    }

    public function decrypt($data, $key) {
        // TODO: Implement decrypt() method.
    }
}