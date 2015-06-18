<?php

namespace app\utils\queries;
use Yii;
use yii\base\Component;
use yii\db\Connection;

/**
 * Class QueryBase
 * @author EntityFX
 */
abstract class QueryBase extends Component {
    /**
     *
     * @var Connection
     */
    protected $db;

    public function __construct()
    {
        $this->db = Yii::$app->db;
    }
}