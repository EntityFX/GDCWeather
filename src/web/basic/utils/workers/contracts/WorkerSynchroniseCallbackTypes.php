<?php

namespace app\utils\workers\contracts;
use Closure;
use yii\base\Component;

/**
 * Class WorkerSynchroniseCallbackTypes
 *
 * @property Closure createCallback     void function(IWebClientProxy, ...params) Анонимная функция создания объекта
 * @property Closure updateCallback     void function(IWebClientProxy, ...params) Анонимная функция редактирования объекта
 * @property Closure deleteCallback     void function(IWebClientProxy, ...params) Анонимная функция удаления объекта
 * @property Closure existsCallback     bool function(IWebClientProxy, ...params) Анонимная функция проверки на существование объекта
 * @property Closure findObjectCallback mixed function(...params) Анонимная поиска объекта в текущем сервисе
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class WorkerSynchroniseCallbackTypes extends Component {
    /**
     * @var Closure
     */
    private $_createCallback;
    /**
     * @var Closure
     */
    private $_updateCallback;
    /**
     * @var Closure
     */
    private $_deleteCallback;
    /**
     * @var Closure
     */
    private $_existsCallback;
    /**
     * @var Closure
     */
    private $_findObjectCallback;

    /**
     * @return callable
     */
    public function getFindObjectCallback() {
        return $this->_findObjectCallback;
    }

    /**
     * @param Closure $findObjectCallback
     */
    public function setFindObjectCallback(Closure $findObjectCallback) {
        $this->_findObjectCallback = $findObjectCallback;
    }

    /**
     * @return Closure
     */
    public function getCreateCallback() {
        return $this->_createCallback;
    }

    /**
     * @param Closure $createCallback
     */
    public function setCreateCallback(Closure $createCallback) {
        $this->_createCallback = $createCallback;
    }

    /**
     * @return Closure
     */
    public function getDeleteCallback() {
        return $this->_deleteCallback;
    }

    /**
     * @param Closure $deleteCallback
     */
    public function setDeleteCallback(Closure $deleteCallback) {
        $this->_deleteCallback = $deleteCallback;
    }

    /**
     * @return Closure
     */
    public function getExistsCallback() {
        return $this->_existsCallback;
    }

    /**
     * @param Closure $existsCallback
     */
    public function setExistsCallback(Closure $existsCallback) {
        $this->_existsCallback = $existsCallback;
    }

    /**
     * @return Closure
     */
    public function getUpdateCallback() {
        return $this->_updateCallback;
    }

    /**
     * @param Closure $updateCallback
     */
    public function setUpdateCallback(Closure $updateCallback) {
        $this->_updateCallback = $updateCallback;
    }
}