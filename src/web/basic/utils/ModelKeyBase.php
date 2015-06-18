<?php

namespace app\utils;
use yii\base\Model;

/**
 * class ModelKeyBase
 * @property int $id Целочисленный ключ
 */
abstract class ModelKeyBase extends Model {
    /** Aggregations: */
    /** Compositions: */
    /*     * * Attributes: ** */

    /**
     * 
     * @access private
     */
    private $_id;

    /**
     * 
     *
     * @return int
     * @access public
     */
    public function getId() {
        return $this->_id;
    }
    
    public function setId($id) {
        $this->_id = $id == null ? null : (int)$id;
    }


}