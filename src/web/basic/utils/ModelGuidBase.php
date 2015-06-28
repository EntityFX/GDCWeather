<?php

namespace app\utils;

/**
 * class ModelGuidBase
 * @property Guid $guid guid-ключ
 */
abstract class ModelGuidBase extends \yii\base\Model {

    /**
     * 
     * @access private
     * @var Guid
     */
    private $_guid;

    /**
     * @return Guid
     * @access public
     */
    public function getGuid() {
        return $this->_guid;
    }
    
    public function setGuid(Guid $guid) {
        $this->_guid = $guid;
    }

// end of member function getGuid
}