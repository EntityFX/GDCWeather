<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Гузалия
 * Date: 29.06.15
 * Time: 2:14
 * To change this template use File | Settings | File Templates.
 */

namespace app\businessLogic\implementation\weatherData\mapper;


use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\dataAccess\entities\WeatherPollingDataEntity;
use app\utils\exceptions\ManagerException;
use app\utils\mappers\BusinessLogicMapperBase;
use DateTime;
use yii\base\Object;
use yii\db\ActiveRecord;

class WeatherDataMapper extends BusinessLogicMapperBase {

    /**
     * @param \app\businessLogic\contracts\weatherData\WeatherDataItem|\yii\base\Object $contract
     *
     * @throws \app\utils\exceptions\ManagerException
     * @return WeatherPollingDataEntity
     */
    public function contractToEntity(Object $contract) {
        /** @var $contract WeatherDataItem */
        if (!($contract instanceof WeatherDataItem)) {
            throw new ManagerException("Wrong type of mapping contract");
        }
        $entity = new WeatherPollingDataEntity();
        $entity->id = $contract->id;
        $entity->temp = $contract->temperature;
        $entity->pressure = $contract->pressure;
        $entity->alt = $contract->altitude;
        $entity->dateTime = $contract->createDateTime->format(DateTime::ISO8601);
        return $entity;
    }

    /**
     * @param \app\dataAccess\entities\WeatherPollingDataEntity $entity
     *
     * @throws \app\utils\exceptions\ManagerException
     *
     * @return WeatherDataItem
     */
    public function entityToContract(ActiveRecord $entity) {
        /** @var $entity WeatherPollingDataEntity */
        if (!($entity instanceof WeatherPollingDataEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }
        $contract = new WeatherDataItem();
        $contract->id = $entity->id;
        $contract->temperature = $entity->temp;
        $contract->pressure = $entity->pressure;
        $contract->altitude = $entity->alt;
        $contract->createDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $entity->dateTime);
        return $entity;
    }
}