<?php

namespace app\utils;

use yii\base\Object;

/**
 * Limit
 *
 * Задаёт ограничение для выборки данных
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common
 */
final class Limit extends Object {

    private $_size;
    private $_offset;

    /**
     * @param int $offest Смещение (от 0)
     * @param int $size Размер данных (по-умолчанию 15)
     */
    public function __construct($offest = 0, $size = 15) {
        $this->_size = (int) $size;
        $this->_offset = (int) $offest;
    }

    /**
     * Возвращает размер данных
     *
     * @return int
     */
    public function getSize() {
        return $this->_size;
    }

    /**
     * Возвращает смещение
     *
     * @return int
     */
    public function getOffset() {
        return $this->_offset;
    }

    /**
     * Возвращает номер страницы
     *
     * @return int
     */
    public function getPageNumber() {
        return (int)($this->_offset / $this->_size  + 1);
    }

}
