<?php

namespace app\utils\workers\implementation\mapper;

use app\utils\exceptions\ManagerException;
use app\utils\mappers\BusinessLogicMapperBase;
use app\utils\workers\contracts\repositories\WorkerData;
use app\utils\workers\contracts\repositories\WorkerStatusEnum;
use app\utils\workers\dataAccess\WorkerEntity;
use DateTime;
use Exception;
use SimpleXMLElement;
use yii\base\Object;
use yii\db\ActiveRecord;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class WorkerMapper extends BusinessLogicMapperBase {

    const WORKER_CONFIG_DEFAULT_XML = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<worker xmlns:workers="http://entityfx.ru/workers" />
XML;

    /**
     * @param \yii\base\Object $contract
     *
     * @return ActiveRecord
     */
    public function contractToEntity(Object $contract) {
        /** @var $contract WorkerData */
        if (!($contract instanceof WorkerData)) {
            throw new ManagerException("Wrong type of mapping contract");
        }
    }

    /**
     * @param ActiveRecord $contract
     *
     * @return \yii\base\Object
     */
    public function entityToContract(ActiveRecord $entity) {
        /** @var $contract WorkerData */
        if (!($entity instanceof WorkerEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }
        $object                = new WorkerData();
        $object->id            = $entity->id;
        $object->workerName    = $entity->name;
        $object->className     = $entity->class;
        $object->status        = new WorkerStatusEnum((int)$entity->status);
        $object->description   = $entity->description;
        $object->startDateTime = $entity->startDatetime === null ? null :
            DateTime::createFromFormat('Y-m-d H:i:s', $entity->startDatetime);
        $object->endDateTime   = $entity->endDatetime === null ? null :
            DateTime::createFromFormat('Y-m-d H:i:s', $entity->endDatetime);
        $object->pid           = $entity->pid;


        if ($entity->xmlConfiguration !== null && $entity->xmlConfiguration) {
            try {
                libxml_use_internal_errors(true);
                $object->configuration = new SimpleXMLElement($entity->xmlConfiguration);
            } catch (Exception $exception) {
                $object->configuration = new SimpleXMLElement(self::WORKER_CONFIG_DEFAULT_XML);
            }
        } else {
            $object->configuration = new SimpleXMLElement(self::WORKER_CONFIG_DEFAULT_XML);
        }

        return $object;
    }
}