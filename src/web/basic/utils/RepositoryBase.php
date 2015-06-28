<?php

namespace app\utils;

use app\utils\enum\EnumBase;
use app\utils\enum\OrderDirectionEnum;
use Yii;
use yii\db\Query;

/**
 * Class RepositoryBase
 *
 * @author EntityFX <artem.solopiy@gmail.com>
 * @package Kontinent\Components\Common
 */
abstract class RepositoryBase extends ComponentBase {
    const REPOSITORY_CATEGORY    = 'app.components.repositories';

    /**
     *
     * @var CDbConnection
     */
    protected $db;

    public function __construct()
    {
        $this->db  = Yii::$app->db;
        $this->ioc = Yii::$app->ioc->container;
    }

    /**
     * Returns ORDER BY token for field enum and order enum
     *
     * @param EnumBase $orderField Field to order
     * @param OrderDirectionEnum $direction       Order direction
     *
     * @return string
     */
    protected function order(EnumBase $orderField, OrderDirectionEnum $direction)
    {
        return $orderField->getValue() . ' ' . $direction->getValue();
    }

    /**
     * Returns count items in table
     *
     * @param string $table SQL table name
     * @param mixed $where where condition
     * @param array $params parameters to bind in
     * @return int Count items
     */
    protected function getCount($table, $where, array $params)
    {
        return (int)((new Query())
            ->from($table)
            ->where($where, $params)
            ->count());
    }

    protected function getCountByCommand($tableName, Query $command)
    {
        $command->from($tableName);

        return (int)$command->count();
    }

    /**
     * Returns id of inserted record
     *
     * @return int
     */
    protected function lastInsertId()
    {
        return (int)$this->db->createCommand('SELECT LAST_INSERT_ID()')
            ->queryScalar();
    }

    /**
     * Возвращает GUID
     *
     * @return Guid
     */
    protected function createGuid()
    {
        return new Guid($this->db->createCommand('SELECT UUID()')->queryScalar());
    }
}