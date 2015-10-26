<?php

namespace app\utils\workers\implementation;

use app\utils\webService\contracts\clientProxies\WebClientProxyInterface;
use app\utils\workers\contracts\settings\WorkerClientProxySettingsInterface;
use app\utils\workers\contracts\settings\WorkerClientProxyXmlSettings;
use app\utils\workers\contracts\WorkerInterface;
use app\utils\workers\contracts\WorkerSynchroniseCallbackTypes;
use app\utils\workers\contracts\WorkerWithProxiesInterface;
use Traversable;
use yii\base\Exception;
use app\utils\exceptions\InternalExceptionBase;
use Closure;
use yii\log\Logger;

/**
 * Class WorkerWithProxiesBase
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
abstract class WorkerWithProxiesBase extends WorkerBase implements WorkerInterface, WorkerWithProxiesInterface {

    const FAULT_CANT_GET_VERSION = 1;
    const FAULT_WRONG_VERSION    = 2;
    /**
     * @var WebClientProxyInterface[]
     */
    private $_webClientProxyList;

    public function onBeginRun(array $args = null) {
        $this->checkProxiesForVersion();
        $this->initClientProxies();
        $clientProxies = $this->getWebClientProxyList();
        if (count($clientProxies) == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * проверяет версию удалённого сервиса для каждого прокси клиента
     */
    private function checkProxiesForVersion() {
        $clientProxies   = $this->getWebClientProxyList();
        $removeProxyList = array();
        foreach ($clientProxies as $index => $clientProxy) {
            $endpoint = $clientProxy->getEndpoint();
            if ($clientProxy instanceof VersionableInterface) {
                try {
                    $version = $clientProxy->getVersion();
                    if ($endpoint->version !== $version) {
                        $this->log("Версия прокси и сервиса различные: {$endpoint->baseUrl}. Client version: {$endpoint->version}, Service version: {$version}", CLogger::LEVEL_WARNING);
                        $removeProxyList[] = $clientProxy;
                    } else {
                        $this->log("Успешная проверка версии: {$endpoint->baseUrl}", Logger::LEVEL_INFO);
                    }
                } catch (Exception $exception) {
                    $this->log("Не удалось получить версию для прокси: {$endpoint->baseUrl}. Exception: {$exception->getMessage()}", CLogger::LEVEL_ERROR);
                    $removeProxyList[] = $clientProxy;
                }
            }
        }
        foreach ($removeProxyList as $removeProxy) {
            $clientProxies->remove($removeProxy);
        }
    }

    /**
     * @return WebClientProxyInterface[]|Traversable
     */
    public function getWebClientProxyList() {
        return $this->_webClientProxyList;
    }

    /**
     * @param Traversable $proxyList
     *
     * @return WebClientProxyInterface[]|Traversable
     */
    public function setWebClientProxyList(array $proxyList) {
        $this->_webClientProxyList = $proxyList;
        $this->initClientProxies();
    }

    /**
     * Инициализирует клиентские прокси (аутентификация, зашифрованные данные, прокси аутентификация)
     */
    private function initClientProxies() {
        $clientProxies = $this->getWebClientProxyList();
        foreach ($clientProxies as $clientProxy) {
            $config = new WorkerClientProxyXmlSettings($this->workerSettings->workerData->configuration);

            $config->setHttpAuthCryptoKey($this->getHttpAuthCryptoKey());
            $config->setHttpProxyAuthCryptoKey($this->getHttpProxyAuthCryptoKey());

            $this->initHttpProxyAuth($clientProxy, $config);
            $this->initHttpAuth($clientProxy, $config);
        }
        $this->initWorkerClientProxies($clientProxies);
    }

    protected function getHttpAuthCryptoKey() {
        return '';
    }

    protected function getHttpProxyAuthCryptoKey() {
        return '';
    }

    private function initHttpProxyAuth(WebClientProxyInterface $clientProxy, WorkerClientProxySettingsInterface $config) {
        $httpProxyAuthConfig = $config->getHttpProxyAuthConfig($clientProxy->endpoint->id);
        if ($httpProxyAuthConfig !== null) {
            $clientProxy->setHttpProxy($httpProxyAuthConfig);
        }
    }

    private function initHttpAuth(WebClientProxyInterface $clientProxy, WorkerClientProxySettingsInterface $config) {
        $httpAuthConfig = $config->getHttpAuthConfig($clientProxy->endpoint->id);
        if ($httpAuthConfig !== null) {
            $clientProxy->setHttpAuth($httpAuthConfig);
        }
    }

    /**
     * Инициализация клиентских прокси
     */
    protected abstract function initWorkerClientProxies($clientProxies);

    /**
     * Выполняет операцию синхронизации
     *
     * @param ObjectHistory                  $objectHistory
     * @param Traversable|WebClientProxyInterface[]        $proxyList
     * @param WorkerSynchroniseCallbackTypes $callBackList
     * @param                                $objectLogName
     * @param array                          $methodLogList
     */
    protected function doAction(ObjectHistory $objectHistory,
                                Traversable $proxyList, WorkerSynchroniseCallbackTypes $callBackList,
                                $objectLogName,
                                array $methodLogList) {
        if (count($proxyList) == 0) return;
        $operation = $objectHistory->type->getValue();

        $operationText = self::getOperationText($objectHistory->type);

        /** @var $proxyList WebClientProxyInterface */
        foreach ($proxyList as $siteUpdateProxy) {
            $endpointUrl    = $siteUpdateProxy->endpoint->baseUrl;
            $proxyClassName = get_class($siteUpdateProxy);

            $serviceOperationCallback = null;
            $methodLogName            = $methodLogList[$operation];

            if ($operation === ObjectHistoryTypeEnum::DELETE) {
                $serviceOperationCallback = $callBackList->deleteCallback;

                $entity = $objectHistory->guid;
            } else {
                $findCallback = $callBackList->findObjectCallback;
                $entity       = $findCallback($objectHistory->guid);

                if ($entity !== null && $callBackList->existsCallback !== null) {
                    $existsMethodLogName = $methodLogList[ObjectHistoryTypeEnum::EXISTS];
                    try {
                        $existsCallback = $callBackList->existsCallback;
                        $isObjectExists = $existsCallback($siteUpdateProxy, $objectHistory->guid);
                        $isObjectExistsText = $isObjectExists ? true : false;
                        $this->logServiceCall($proxyClassName, $existsMethodLogName,
                            $endpointUrl, self::getOperationText(new ObjectHistoryTypeEnum(ObjectHistoryTypeEnum::EXISTS)),
                            $objectLogName, $objectHistory->guid->value, "[$isObjectExistsText]");

                        if ($operation === ObjectHistoryTypeEnum::UPDATE && !$isObjectExists ||
                            $operation === ObjectHistoryTypeEnum::CREATE && !$isObjectExists
                        ) {
                            $serviceOperationCallback = $callBackList->createCallback;
                        } elseif ($operation === ObjectHistoryTypeEnum::UPDATE && $isObjectExists) {
                            $serviceOperationCallback = $callBackList->updateCallback;
                        } else {
                            continue;
                        }
                    } catch (Exception $exception) {
                        $this->logServiceCallException($exception,
                            $proxyClassName, $existsMethodLogName, $endpointUrl, $operationText, $objectLogName);
                        $this->getUpdateService()->failUpdateObject($objectHistory, $siteUpdateProxy->getEndpoint());
                        continue;
                    }
                }
            }

            if ($serviceOperationCallback !== null) {
                $this->performServiceCall($entity,
                    $serviceOperationCallback,
                    $objectHistory, $endpointUrl, $siteUpdateProxy, $objectLogName, $methodLogName, $proxyClassName,
                    $operationText);
            }
        }

    }

    private static function getOperationText(ObjectHistoryTypeEnum $enum) {
        switch ($enum->getValue()) {
            case ObjectHistoryTypeEnum::CREATE:
                return 'создание';
            case ObjectHistoryTypeEnum::UPDATE:
                return 'редактирование';
            case ObjectHistoryTypeEnum::DELETE:
                return 'удаление';
            case ObjectHistoryTypeEnum::EXISTS:
                return 'существование';
            default :
                return '{unknown}';
        }
    }

    /**
     * логирует успешный вызов сервиса
     *
     * @param        $proxyClassName
     * @param        $methodLogName
     * @param        $endpointUrl
     * @param        $operationText
     * @param        $objectLogName
     * @param        $param
     * @param string $result
     */
    private function logServiceCall($proxyClassName, $methodLogName, $endpointUrl, $operationText, $objectLogName, $param, $result = '') {
        $result = $result === '' ? '' : "Результат: $result";
        $this->log("Вызов сервиса $proxyClassName::$methodLogName, endpoint:
            $endpointUrl на {$operationText} {$objectLogName} [{$param}] успешно завершено. {$result}");
    }

    /**
     * Логирует исключение вызова сервиса
     *
     * @param Exception $exception
     * @param string    $proxyClassName
     * @param string    $methodLogName
     * @param string    $endpointUrl
     * @param string    $operationText
     * @param string    $objectLogName
     */
    private function logServiceCallException(Exception $exception,
                                             $proxyClassName,
                                             $methodLogName,
                                             $endpointUrl, $operationText, $objectLogName) {
        $exceptionClassName = get_class($exception);
        $errorMessage       = "Ошибка вызова сервиса $proxyClassName::$methodLogName, endpoint: {$endpointUrl} на {$operationText} {$objectLogName},
                Exception: $exceptionClassName with message \"{$exception->getMessage()}\"";

        while ($exception instanceof InternalExceptionBase) {
            $internalException = $exception->getInternalException();
            if ($internalException !== null) {
                $errorMessage .= ", \t\nInternal exception: \"{$internalException->getMessage()}\" :";
                $errorMessage .= "\t\t\n Trace:" . $internalException->getTraceAsString();
            }
            $exception = $internalException;
        }

        $this->log($errorMessage, Logger::LEVEL_WARNING);
    }

    /**
     * @return IUpdateService
     */
    protected function getUpdateService() {
        return $this->ioc->create('IUpdateService');
    }

    /**
     * @param                 $param
     * @param callable        $serviceOperationCallback
     * @param ObjectHistory   $objectHistory
     * @param                 $endpointUrl
     * @param WebClientProxyInterface $siteUpdateProxy
     * @param string          $objectLogName
     * @param string          $methodLogName
     * @param                 $proxyClassName
     * @param                 $operationText
     */
    private function performServiceCall($param, Closure $serviceOperationCallback,
                                        ObjectHistory $objectHistory, $endpointUrl, WebClientProxyInterface $siteUpdateProxy,
                                        $objectLogName, $methodLogName, $proxyClassName,
                                        $operationText) {
        try {
            $serviceOperationCallback($siteUpdateProxy, $param);
            $this->logServiceCall($proxyClassName, $methodLogName,
                $endpointUrl, $operationText, $objectLogName, $objectHistory->guid->value);
            $this->getUpdateService()->successUpdateObject($objectHistory, $siteUpdateProxy->getEndpoint());
        } catch (Exception $exception) {
            $this->logServiceCallException($exception,
                $proxyClassName, $methodLogName, $endpointUrl, $operationText, $objectLogName);
            $this->getUpdateService()->failUpdateObject($objectHistory, $siteUpdateProxy->getEndpoint());
        }
    }

}