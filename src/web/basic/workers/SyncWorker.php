<?php
namespace app\workers;

use app\utils\exceptions\WorkerException;
use app\utils\workers\implementation\WorkerBase;
use app\utils\workers\implementation\WorkerWithProxiesBase;
use yii\base\Exception;


/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
final class SyncWorker extends WorkerWithProxiesBase {

    public function onBeginRun(array $args = null) {
        return true;
    }

    public function onEndRun() {
        //echo "ended!";
    }

    public function onFailed(\app\utils\exceptions\WorkerException $exception) {
        //echo "failed";
        return false;
    }

    /**
     * @param array $args
     *
     */
    public function run(array $args = null) {
        //sleep(1);
    }

    /**
     * Инициализация клиентских прокси
     */
    protected function initWorkerClientProxies($clientProxies) {
        var_dump($clientProxies);
    }
}