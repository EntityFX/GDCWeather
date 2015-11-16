<?php
namespace app\workers;

use entityfx\utils\exceptions\WorkerException;
use entityfx\utils\workers\implementation\WorkerBase;
use entityfx\utils\workers\implementation\WorkerWithProxiesBase;
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

    public function onFailed(\entityfx\utils\exceptions\WorkerException $exception) {
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
     * ������������� ���������� ������
     */
    protected function initWorkerClientProxies($clientProxies) {
        var_dump($clientProxies);
    }
}