<?php
/**
 * Created by PhpStorm.
 * User: odroid
 * Date: 7/7/15
 * Time: 5:46 a.m.
 */

namespace app\models;

use Yii;
use yii\base\Model;


class ChartDataItemModel extends Model {

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $dateTime;

    /**
     * @var float
     */
    public $temperature;
}