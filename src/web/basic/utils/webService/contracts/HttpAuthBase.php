<?php

namespace app\utils\webService\contracts;
use yii\base\Component;

/**
 * Class HttpAuthBase
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property string $login
 * @property string $password
 */
abstract class HttpAuthBase extends Component {
    private $_login;

    private $_password;

    public function setLogin($login) {
        $this->_login = (string)$login;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function setPassword($password) {
        $this->_password = (string)$password;
    }

    public function getPassword() {
        return $this->_password;
    }
}