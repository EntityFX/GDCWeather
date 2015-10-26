<?php

namespace app\utils\workers\implementation\repositories;

use app\utils\exceptions\WorkerException;
use app\utils\Limit;
use app\utils\mappers\BusinessLogicMapperBase;
use app\utils\RepositoryBase;
use app\utils\workers\contracts\repositories\WorkerData;
use app\utils\workers\contracts\repositories\WorkerRepositoryInterface;
use app\utils\workers\contracts\repositories\WorkerRetrieveResult;
use app\utils\workers\contracts\repositories\WorkerStatusEnum;
use app\utils\workers\dataAccess\WorkerClientProxyXrefEntity;
use app\utils\workers\dataAccess\WorkerEntity;
use yii\db\IntegrityException;
use yii\db\Query;

/**
 * Class WorkerRepository
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 */
class WorkerRepository extends RepositoryBase implements WorkerRepositoryInterface {

    private $_mapper;

    public function __construct(BusinessLogicMapperBase $mapper) {
        parent::__construct();
        $this->_mapper = $mapper;
    }

    /**
     * @param int $workerId
     *
     * @return WorkerData
     */
    public function getById($workerId) {
        $entity = WorkerEntity::findOne($workerId);

        return $entity != null ? $this->_mapper->entityToContract($entity) : null;
    }

    /**
     * @param Limit $limit
     *
     * @return WorkerData[]
     */
    public function retrieve(Limit $limit) {
        $retrieveResult = new WorkerRetrieveResult();

        $retrieveQuery = WorkerEntity::find();

        $countQuery = $retrieveQuery->prepare(new Query());
        $retrieveResult->totalItems = $countQuery->count();

        $items = $retrieveQuery
            ->limit($limit->getSize())
            ->offset($limit->getOffset())
            ->all();

        $sensorVendorItems = [];
        foreach ($items as $item) {
            $sensorVendorItems[] = $this->mapper->entityToContract($item);
        }

        $retrieveResult->dataItems = $sensorVendorItems;

        return $retrieveResult;
    }

    /**
     * @param $workerId
     *
     * @return int[]|array
     */
    public function getWorkerWebClientIdList($workerId) {
        $data = WorkerClientProxyXrefEntity::find()
                                           ->select('clientProxyId')
                                           ->where(['workerId' => (int)$workerId])
                                           ->column();

        return $data;
    }

    public function updateWorkerStatus(WorkerData $worker) {

        $updateDataArray = [
            'status' => $worker->status->getValue(),
            'pid'    => $worker->pid
        ];

        if ($worker->status->getValue() === WorkerStatusEnum::IN_PROGRESS) {
            $updateDataArray = $updateDataArray + [
                    'startDateTime' => $worker->startDateTime === null ? null : $worker->startDateTime->format(
                        'Y-m-d H:i:s'
                    ),
                    'endDateTime'   => null
                ];
        } else {
            $updateDataArray = $updateDataArray + [
                    'endDateTime' => $worker->endDateTime === null ? null : $worker->endDateTime->format(
                        'Y-m-d H:i:s'
                    )
                ];
        }

        try {
            WorkerEntity::updateAll($updateDataArray, ['id' => $worker->id]);
        } catch (IntegrityException $exception) {
            throw new WorkerException($exception->getMessage(), null, $exception);
        }

    }

    /**
     * @return int
     */
    public function count() {
        return WorkerEntity::find()->count();
    }
}