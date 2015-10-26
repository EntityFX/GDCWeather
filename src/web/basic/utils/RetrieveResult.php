<?php

namespace app\utils;
use yii\base\Object;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class RetrieveResult extends Object {
    /**
     * @var int
     */
    private $_totalItems = 0;

    private $_dataItems;

    /**
     * @return int
     */
    public function getTotalItems() {
        return $this->_totalItems;
    }

    /**
     * @param int $totalItems
     */
    public function setTotalItems($totalItems) {
        $this->_totalItems = (int)$totalItems;
    }

    /**
     * @return Object[]
     */
    public function getDataItems() {
        return $this->_dataItems;
    }

    /**
     * @param Object[] $dataItems
     */
    public function setDataItems(array $dataItems) {
        $this->_dataItems = $dataItems;
    }
}