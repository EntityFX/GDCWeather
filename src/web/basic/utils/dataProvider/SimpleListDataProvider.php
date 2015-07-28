<?php
/**
 * Created by PhpStorm.
 * User: SolopiyA
 * Date: 07.07.15
 * Time: 18:28
 */

namespace app\utils\dataProvider;


use yii\data\BaseDataProvider;
use yii\helpers\ArrayHelper;

class SimpleListDataProvider extends BaseDataProvider {

    /** @var array the data that is not paginated or sorted. When pagination is enabled,
     * this property usually contains more elements than [[models]].
     * The array elements must use zero-based integer keys.
     */
    public $allModels;

    public $key;

    public $_totalCountInResult;

    /**
     * Prepares the data models that will be made available in the current page.
     * @return array the available data models
     */
    protected function prepareModels() {
        if (($models = $this->allModels) === null) {
            return [];
        }

        if (($sort = $this->getSort()) !== false) {
            //$models = $this->sortModels($models, $sort);
        }

        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();

            if ($pagination->getPageSize() > 0) {
                //$models = array_slice($models, $pagination->getOffset(), $pagination->getLimit(), true);
            }
        }

        return $models;
    }

    /**
     * Prepares the keys associated with the currently available data models.
     * @param array $models the available data models
     * @return array the keys
     */
    protected function prepareKeys($models) {
        if ($this->key !== null) {
            $keys = [];
            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $keys[] = $model[$this->key];
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }

            return $keys;
        } else {
            return array_keys($models);
        }
    }

    /**
     * Returns a value indicating the total number of data models in this data provider.
     * @return integer total number of data models in this data provider.
     */
    protected function prepareTotalCount() {
        return $this->_totalCountInResult;
    }

    /**
     * @param mixed $totalCountInResult
     */
    public function setTotalCountInResult($totalCountInResult) {
        $this->_totalCountInResult = (int)$totalCountInResult;
    }

    /**
     * @return mixed
     */
    public function getTotalCountInResult() {
        return $this->_totalCountInResult;
    }


    protected function sortModels($models, $sort) {
        $orders = $sort->getOrders();
        if (!empty($orders)) {
            ArrayHelper::multisort($models, array_keys($orders), array_values($orders));
        }

        return $models;
    }


}