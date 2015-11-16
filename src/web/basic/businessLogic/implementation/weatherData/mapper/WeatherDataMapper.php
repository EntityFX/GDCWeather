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
use entityfx\utils\exceptions\ManagerException;
use entityfx\utils\Guid;
use entityfx\utils\mappers\BusinessLogicMapperBase;
use DateTime;
use yii\base\Object;
use yii\db\ActiveRecord;

class WeatherDataMapper extends BusinessLogicMapperBase {

    /**
     * @param \app\businessLogic\contracts\weatherData\WeatherDataItem|\yii\base\Object $contract
     *
     * @throws \entityfx\utils\exceptions\ManagerException
     * @return WeatherPollingDataEntity
     */
    public function contractToEntity(Object $contract) {
        /** @var $contract WeatherDataItem */
        if (!($contract instanceof WeatherDataItem)) {
            throw new ManagerException("Wrong type of mapping contract");
        }
        $entity       = new WeatherPollingDataEntity();
        $entity->id   = $contract->id->toBinaryString();
        $entity->temp = $contract->temperature;
        $entity->pressure = $contract->pressure;
        $entity->alt  = $contract->altitude;
        $entity->dateTime = $contract->createDateTime->format(DateTime::ISO8601);
        $entity->sensorId = $contract->sensor->id->toBinaryString();
        return $entity;
    }

    /**
     * @param \app\dataAccess\entities\WeatherPollingDataEntity $entity
     *
     * @throws \entityfx\utils\exceptions\ManagerException
     *
     * @return WeatherDataItem
     */
    public function entityToContract(ActiveRecord $entity) {
        /** @var $entity WeatherPollingDataEntity */
        if (!($entity instanceof WeatherPollingDataEntity)) {
            throw new ManagerException("Wrong type of mapping entity");
        }
        $contract              = new WeatherDataItem();
        $contract->id          = Guid::parseBinaryString($entity->id);
        $contract->temperature = $entity->temp;
        $contract->pressure    = $entity->pressure;
        $contract->altitude    = $entity->alt;
        $contract->createDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $entity->dateTime);

        return $contract;
    }
}