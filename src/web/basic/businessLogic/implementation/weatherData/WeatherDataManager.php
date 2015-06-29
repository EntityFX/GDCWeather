<?php

namespace app\businessLogic\implementation\weatherData;

use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilterBase;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveLastFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\businessLogic\contracts\weatherData\WeatherDataRetrieveResult;
use app\businessLogic\implementation\weatherData\mapper\WeatherDataMapper;
use app\dataAccess\entities\WeatherPollingDataEntity;
use app\utils\Limit;
use app\utils\ManagerBase;
use DateTime;
use SplFixedArray;
use yii\db\Query;
use yii\helpers\VarDumper;

class WeatherDataManager extends ManagerBase implements WeatherDataManagerInterface {

    private $_intervalMap = [
        WeatherDataBackIntervalEnum::LAST_TEN_MINUTES   => '-10 minutes',
        WeatherDataBackIntervalEnum::LAST_FIRTH_MINUTES => '-30 minutes',
        WeatherDataBackIntervalEnum::LAST_HOUR          => '-1 hour',
        WeatherDataBackIntervalEnum::LAST_THREE_HOURS   => '-3 hours',
        WeatherDataBackIntervalEnum::LAST_HALF_DAY      => '-12 hours',
        WeatherDataBackIntervalEnum::LAST_DAY           => '-1 day',
        WeatherDataBackIntervalEnum::LAST_THREE_DAYS    => '-3 days',
        WeatherDataBackIntervalEnum::LAST_WEEK          => '-1 week',
    ];

    function __construct() {
        parent::__construct();
    }

    protected function initMapper() {
        return new WeatherDataMapper();
    }

    /**
     * @param WeatherDataRetrieveFilterBase $filter
     *
     * @param \app\utils\Limit              $limit
     * @param WeatherDataRetrieveOrder      $order
     *
     * @return WeatherDataRetrieveResult
     */
    public function retrieve(WeatherDataRetrieveFilterBase $filter, Limit $limit, WeatherDataRetrieveOrder $order) {
        $result = new WeatherDataRetrieveResult();

        $retrieveQuery = WeatherPollingDataEntity::find();
        if ($filter instanceof WeatherDataRetrieveLastFilter) {
            $currentDateTime = new DateTime();
            $res             = \DateInterval::createFromDateString(
                $this->_intervalMap[$filter->backInterval->getValue()]
            );
            $backTime        = $currentDateTime->add($res)->format('Y-m-d H:i:s');
            $retrieveQuery   = $retrieveQuery->where(
                ['>=', 'dateTime', $backTime]
            );
        }

        $statisticsQuery = $retrieveQuery->prepare(new Query());
        $res1 = $statisticsQuery->select(
            [
                'MAX(`temp`) AS MaxTemp',
                'MIN(`temp`) AS MinTemp',
                'AVG(`temp`) AS AvgTemp',
            ]
        )->one();

        $weatherDataEntityItems = $retrieveQuery
            ->limit($limit->getSize())
            ->offset($limit->getOffset())
            ->all();
        $weatherDataItems       = new SplFixedArray(count($weatherDataEntityItems));
        foreach ($weatherDataEntityItems as $index => $item) {
            $weatherDataItems[$index] = $this->mapper->entityToContract($item);
        }

        $result->dataItems = $weatherDataItems;

        return $result;
    }
}