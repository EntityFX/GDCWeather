<?php
namespace app\utils\webService\contracts;

/**
 * Class HttpAuthDigest
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @property string $realm;
 */
class HttpAuthDigest extends HttpAuthBase {
    /**
     * @var string
     */
    private $_realm;

    /**
     * @param string $realm
     */
    public function setRealm($realm) {
        $this->_realm = (string)$realm;
    }

    /**
     * @return string
     */
    public function getRealm() {
        return $this->_realm;
    }
}