<?php

namespace app\utils\workers\contracts\settings;
use app\utils\webService\HttpProxy;
use app\utils\webService\HttpAuthBase;

/**
 * Class IWorkerClientProxySettings
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
interface WorkerClientProxySettingsInterface {
    /**
     * @param string $key
     */
    public function setHttpAuthCryptoKey($key);

    /**
     * @param string $key
     */
    public function setHttpProxyAuthCryptoKey($key);

    /**
     * @param $clientProxyId
     *
     * @return HttpProxy|null
     */
    public function getHttpProxyAuthConfig($clientProxyId);

    /**
     * @param $clientProxyId
     *
     * @return HttpAuthBase|null
     */
    public function getHttpAuthConfig($clientProxyId);
}