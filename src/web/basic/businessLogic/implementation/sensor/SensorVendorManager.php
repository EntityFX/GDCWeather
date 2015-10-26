<?php
namespace app\businessLogic\implementation\sensor;

use app\businessLogic\contracts\sensor\ordering\SensorVendorOrder;
use app\businessLogic\contracts\sensor\SensorVendor;
use app\businessLogic\contracts\sensor\SensorVendorManagerInterface;
use app\businessLogic\contracts\sensor\SensorVendorRetrieveResult;
use app\businessLogic\implementation\sensor\mapper\SensorVendorMapper;
use app\dataAccess\entities\SensorVendorEntity;
use app\utils\exceptions\ManagerException;
use app\utils\Guid;
use app\utils\Limit;
use app\utils\ManagerBase;
use app\utils\order\OrderBase;
use yii\db\IntegrityException;
use yii\db\Query;

/**
 * @link      http://entityfx.ru
 * @copyright Copyright (c) 2015 GDCWeather
 * @author    :
 */
class SensorVendorManager extends ManagerBase implements SensorVendorManagerInterface {

    /**
     * @param SensorVendor $sensorVendor
     * @return SensorVendor
     * @throws ManagerException
     */
    function create(SensorVendor $sensorVendor) {
        $vendorEntity = $this->mapper->contractToEntity($sensorVendor);
        try {
            $vendorEntity->save();
        } catch (IntegrityException $integrityException) {
            throw new ManagerException("Vendor already exists", "", "", $integrityException);
        }

        return $sensorVendor;
    }

    function retrieve(Limit $limit, SensorVendorOrder $order) {
        $retrieveResult = new SensorVendorRetrieveResult();

        $retrieveQuery = SensorVendorEntity::find();

        $countQuery                 = $retrieveQuery->prepare(new Query());
        $retrieveResult->totalItems = $countQuery->count();

        $items = $retrieveQuery
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
        $entity = SensorVendorEntity::findOne(['id', $id->toBinaryString()]);

        return $entity != null ? $this->mapper->entityToContract($entity) : null;
    }

    function update(SensorVendor $sensorVendor) {
        $vendorEntity = $this->mapper->contractToEntity($sensorVendor);
        $vendorEntity->setOldAttribute('id', $sensorVendor->id->toBinaryString());
        $vendorEntity->update();
    }

    function delete(Guid $id) {
        SensorVendorEntity::deleteAll('id = :id', [':id' => $id->toBinaryString()]);
    }

    protected function initMapper() {
        return new SensorVendorMapper();
    }

    public function getOrderField(OrderBase $ord) {
        switch ($ord->getField()) {
            case SensorVendorOrder::ID:
                return 'id';
                break;
            case SensorVendorOrder::NAME:
                return 'temp';
                break;
        }

        return 'id';
    }
}