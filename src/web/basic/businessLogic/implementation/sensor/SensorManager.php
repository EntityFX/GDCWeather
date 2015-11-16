<?php
/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */

namespace app\businessLogic\implementation\sensor;


use app\businessLogic\contracts\ContractObjectHistoryCategoryEnum;
use app\businessLogic\contracts\sensor\ordering\SensorOrder;
use app\businessLogic\contracts\sensor\Sensor;
use app\businessLogic\contracts\sensor\SensorManagerInterface;
use app\businessLogic\contracts\sensor\SensorRetrieveResult;
use app\businessLogic\implementation\sensor\mapper\SensorMapper;
use app\dataAccess\entities\SensorEntity;
use entityfx\utils\exceptions\ManagerException;
use entityfx\utils\Guid;
use entityfx\utils\Limit;
use entityfx\utils\ManagerBase;
use entityfx\utils\objectHistory\contracts\enums\HistoryTypeEnum;
use entityfx\utils\objectHistory\ObjectHistory;
use entityfx\utils\objectHistory\ObjectHistoryEvent;
use entityfx\utils\order\OrderBase;
use Yii;
use yii\db\IntegrityException;
use yii\db\Query;

class SensorManager extends ManagerBase implements SensorManagerInterface {

    function create(Sensor $sensor) {
        $sensorEntity = $this->mapper->contractToEntity($sensor);
        try {
            $sensorEntity->save();
        } catch (IntegrityException $integrityException) {
            Yii::error($integrityException->getMessage());
            throw new ManagerException("Cannot create sensor", "", "", $integrityException);
        }

        $this->triggerComponentEvent(
            ObjectHistory::EVENT_OBJECT_CHANGED,
            new ObjectHistoryEvent(
                new HistoryTypeEnum(HistoryTypeEnum::CREATE),
                $sensor->id,
                ContractObjectHistoryCategoryEnum::SENSOR
            ), Yii::$app->objectHistory);

        return $sensor;
    }

    function retrieve(Limit $limit, SensorOrder $order) {
        $retrieveResult = new SensorRetrieveResult();

        $retrieveQuery = SensorEntity::find();

        $countQuery                 = $retrieveQuery->prepare(new Query());
        $retrieveResult->totalItems = $countQuery->count();


        $items = SensorEntity::find()
                             ->with('vendor')
                             ->limit($limit->getSize())
                             ->offset($limit->getOffset())
                             ->orderBy(
                                 $this->getOrderExpression(
                                     $order, function ($param) {
                                     return $this->getOrderField($param);
                                 }
                                 )
                             )
                             ->all();

        $sensorVendorItems = [];
        foreach ($items as $item) {
            $sensorVendorItems[] = $this->mapper->entityToContract($item);
        }

        $retrieveResult->dataItems = $sensorVendorItems;

        return $retrieveResult;
    }

    function getById(Guid $id) {
        $entity = SensorEntity::find()
                              ->with('vendor')
                              ->andWhere(['id' => $id->toBinaryString()])
                              ->one();
        return $entity != null ? $this->mapper->entityToContract($entity) : null;
    }

    function update(Sensor $sensor) {
        $sensorEntity = $this->mapper->contractToEntity($sensor);
        $sensorEntity->setOldAttribute('id', $sensor->id->toBinaryString());
        $sensorEntity->update();

        $this->triggerComponentEvent(
            ObjectHistory::EVENT_OBJECT_CHANGED,
            new ObjectHistoryEvent(
                new HistoryTypeEnum(HistoryTypeEnum::UPDATE),
                $sensor->id,
                ContractObjectHistoryCategoryEnum::SENSOR
            ), Yii::$app->objectHistory);
    }

    function delete(Guid $id) {
        SensorEntity::deleteAll('id = :id', [':id' => $id->toBinaryString()]);

        $this->triggerComponentEvent(
            ObjectHistory::EVENT_OBJECT_CHANGED,
            new ObjectHistoryEvent(
                new HistoryTypeEnum(HistoryTypeEnum::DELETE),
                $id,
                ContractObjectHistoryCategoryEnum::SENSOR
            ), Yii::$app->objectHistory);
    }

    public function getOrderField(OrderBase $ord) {
        switch ($ord->getField()) {
            case SensorOrder::ID:
                return 'id';
                break;
        }

        return 'id';
    }

    protected function initMapper() {
        return new SensorMapper();
    }

}