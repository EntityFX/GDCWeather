<?php

namespace app\utils\webService\contracts\services;
use yii\base\Component;

/**
 * Настройки прокси
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property string $url
 * @property string $login
 * @property string $password
 */
class HttpProxy extends Component {
    /**
     * @var string
     */
    private $_url;

    /**
     * @var string
     */
    private $_login;

    /**
     * @var string
     */
    private $_password;

    function __construct($url) {
        $this->_url = (string)$url;
    }

    /**
     * @param $login
     */
    public function setLogin($login) {
        $this->_login = (string)$login;
    }

    /**
     * @return string
     */
    public function getLogin() {
        return $this->_login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->_password = (string)$password;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->_password;
    }

    /**
     * @param string $url
     */
    public function setUrl($url) {
        $this->_url = (string)$url;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }
}