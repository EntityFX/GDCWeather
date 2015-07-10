<?php
/**
 * Created by PhpStorm.
 * User: SolopiyA
 * Date: 10.07.2015
 * Time: 21:38
 */

namespace app\models;


use yii\base\Model;

class ChartDataRequestModel extends Model {
    public $pointsCount;

    public $period;

    public $startDateTime;

    public function rules() {
        return [
            // name, email, subject и body атрибуты обязательны
            [['pointsCount', 'period', 'startDateTime'], 'required'],
            ['pointsCount', 'integer', 'min' => 1, 'max' => 50],
        ];
    }
}