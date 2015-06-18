<?php

namespace app\utils\queries;
use app\utils\filters\FilterBase;
use app\utils\Guid;
use app\utils\Limit;
use app\utils\order\OrderBase;
use ReflectionClass;
use Yii;

/**
 * Class QueryFactory
 * @author
 */
class QueryFactory {
    /**
     * @param $query string Класс запроса
     * @param FilterBase $filter Фильтр запроса
     * @param OrderBase $order Сортировка
     * @param Limit $limit Лимит
     * @return QueryInterface
     */
    public static function createFind($query, FilterBase $filter = null, OrderBase $order = null, Limit $limit = null) {
        return new $query($filter, $order, $limit);
    }

    /**
     * @param $query string Класс запроса
     * @param $id Guid|int
     * @return QueryInterface
     */
    public static function createFindById($query, $id) {
        return new $query($id);
    }

    /**
     * @param $query string Класс запроса
     * @param array $params
     * @return QueryInterface
     */
    public static function create($query, array $params = array()) {
        $class = new ReflectionClass($query);
        return $class->newInstanceArgs($params);
    }
}