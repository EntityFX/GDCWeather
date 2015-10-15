<?php

namespace app\utils;
use yii\base\Component;
use app\utils\exceptions\ValidationException;

/**
 * class Guid
 * @property-read string $value Возвращает строковое значение без фигурных скобок
 */
final class Guid {

    const GUID_REGEXP = "/^\{?[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}\}?$/i";

    /**
     * 
     * @access private
     * @var array
     */
    private $_value;

    private function __construct(array $value) {
        if (count($value) <> 16) {
            throw new \InvalidArgumentException('Error creating guid from byte array');
        }
        $this->_value = $value;
    }

    public function __toString() {
        return self::format(true, true);
    }

    public function getValue() {
        return $this->_value;
    }

    public static function parse($value) {
        if (preg_match(self::GUID_REGEXP, $value)) {
            $res        = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            $flatString = str_replace(['{', '}', '-'], "", $value);
            var_dump($flatString);
            $counter = 0;

            $processReverseFillCallback = function ($start, $end) use (&$res, &$counter, $flatString) {
                for ($index = $start; $index >= $end; $index -= 2) {
                    $res[$counter] = hexdec($flatString[$index] . $flatString[$index + 1]);
                    ++$counter;
                }
            };

            $processReverseFillCallback(6, 0);
            $processReverseFillCallback(10, 8);
            $processReverseFillCallback(14, 12);

            for ($index = 16; $index < 32; $index += 2) {
                $res[$counter] = hexdec($flatString[$index] . $flatString[$index + 1]);
                ++$counter;
            }

            return Guid::fromArray($res);
        } else {
            throw new ValidationException('Error creating guid');
        }
    }

    public static function generate() {
        if (function_exists('com_create_guid') === true) {
            return Guid::parse(com_create_guid());
        }
        $data    = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return Guid::parseBinaryString($data);
    }

    public static function parseBinaryString($value) {
        if (strlen($value) <> 16) {
            throw new \InvalidArgumentException('Error creating guid from byte array');
        }
        $res = [];
        for ($index = 0; $index < strlen($value); ++$index) {
            $res[$index] = ord($value[$index]);
        }

        return new Guid($res);
    }

    public static function fromArray(array $value) {
        return new Guid($value);
    }

    public function toByteArray() {
        return $this->_value;
    }

    public function toBinaryString() {
        $res = '';
        foreach ($this->_value as $byte) {
            $res .= chr($byte);
        }

        return $res;
    }

    public function format($useBraces = false, $useHyphens = false) {
        $res          = self::prepareHexStings($this->_value);
        $joinedString = implode($useHyphens ? '-' : '', $res);

        return strtoupper($useBraces ? '{' . $joinedString . '}' : $joinedString);
    }

    private static function prepareHexStings(array $value) {
        return [
            0 => sprintf('%02X', $value[3])
                . sprintf('%02X', $value[2])
                . sprintf('%02X', $value[1])
                . sprintf('%02X', $value[0]),

            1 => sprintf('%02X', $value[5])
                . sprintf('%02X', $value[4]),

            2 => sprintf('%02X', $value[7])
                . sprintf('%02X', $value[6]),

            3 => sprintf('%02X', $value[8])
                . sprintf('%02X', $value[9]),

            4 => sprintf('%02X', $value[10])
                . sprintf('%02X', $value[11])
                . sprintf('%02X', $value[12])
                . sprintf('%02X', $value[13])
                . sprintf('%02X', $value[14])
                . sprintf('%02X', $value[15])
        ];
    }
}