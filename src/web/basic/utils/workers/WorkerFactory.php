<?php

namespace app\utils\workers;

use app\utils\exceptions\WorkerException;
use app\utils\webService\clientProxies\WebClientProxyFactory;
use app\utils\workers\repositories\WorkerData;
use app\utils\workers\repositories\WorkerRepositoryInterface;
use yii\base\Exception;
use yii\di\ServiceLocator;

class WorkerFactory {
    /**
     * @param int $workerId
     *
     * @throws WorkerException
     * @return WorkerInterface
     */
    public static function createWorker($workerId) {
        /** @var $workerRepository WorkerRepositoryInterface */
        $workerRepository = self::getIoc()->get('WorkerRepositoryInterface');
        /** @var $workerData WorkerData */
        $workerData = $workerRepository->getWorker($workerId);
        if ($workerData == null) {
            throw new WorkerException("Worker doesn't exist", WorkerInterface::FAULT_WORKER_DOESNT_EXIST);
        }

        $workerSettings = new WorkerSettings();
        $workerSettings->workerData = $workerData;

        try {
            /** @var $worker WorkerInterface */
            $worker = self::getIoc()->get($workerData->className);
            $worker->setWorkerSettings($workerSettings);
        } catch(Exception $exception) {
            throw new WorkerException("Cannot instantiate worker '{$workerData->className}'", WorkerInterface::FAULT_WORKER_DOESNT_EXIST, $exception);
        }

        /** @var $worker WorkerWithProxiesInterface */
        if ($worker instanceof WorkerWithProxiesInterface) {
            $workerWebClientProxyList = $workerRepository->getWorkerWebClientIdList($workerId);
            $webClientProxyList = self::createWebClientProxies($workerWebClientProxyList);
            $worker->setWebClientProxyList($webClientProxyList);
        }
        return new WorkerInterfaceInterceptor($worker, $workerRepository);

    }

    public static function createWorkerAndRun($workerId, array $args = null) {
        $worker = self::createWorker($workerId);

        if ($worker !== null) $worker->run($args);
    }

    /**
     * @return ServiceLocator
     */
    private static function getIoc() {
        return new ServiceLocator();
    }

    public static function createWebClientProxies($proxyIdList) {
        $proxyList = new \ArrayObject();
        foreach($proxyIdList as $proxyId) {
            $proxyList[] = WebClientProxyFactory::create($proxyId);
        }
        return $proxyList;
    }
}