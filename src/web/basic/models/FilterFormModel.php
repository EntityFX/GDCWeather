<?php
/**
 * Created by PhpStorm.
 * User: SolopiyA
 * Date: 09.07.2015
 * Time: 18:09
 */

namespace app\models;


use app\businessLogic\contracts\weatherData\enums\WeatherChartPointsCountEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use Yii;
use yii\base\Model;

class FilterFormModel extends Model {
    public $startDateTime;

    public $backPeriod = WeatherDataBackIntervalEnum::LAST_HOUR;

    public $pointsCount = WeatherChartPointsCountEnum::FIFTY;

    /**
     * FilterFormModel constructor.
     */
    public function __construct(array $config = []) {
        parent::__construct();
        $this->startDateTime = Yii::$app->formatter->asDatetime(new \DateTime(), 'short');
    }

    public function rules() {
        return [
            // name, email, subject и body атрибуты обязательны
            [['startDateTime', 'backPeriod', 'pointsCount'], 'required'],
            [['startDateTime'], 'app\utils\validators\DateTimeValidator', 'format' => 'short'],
        ];
    }

    public function attributeLabels() {
        return [
            'startDateTime' => Yii::t('app', '#Datetime#'),
            'backPeriod'    => Yii::t('app', '#Period#'),
            'pointsCount' => Yii::t('app', '#Chart points#'),
        ];
    }
}