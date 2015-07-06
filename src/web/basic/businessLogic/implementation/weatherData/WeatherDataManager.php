<?php

namespace app\businessLogic\implementation\weatherData;

use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilterBase;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveLastFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\businessLogic\contracts\weatherData\WeatherDataRetrieveResult;
use app\businessLogic\contracts\weatherData\WeatherDataStatistics;
use app\businessLogic\implementation\weatherData\mapper\WeatherDataMapper;
use app\dataAccess\entities\WeatherPollingDataEntity;
use app\utils\Limit;
use app\utils\ManagerBase;
use app\utils\order\OrderBase;
use Closure;
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
                'MAX(`temp`) AS maxTemp',
                'MIN(`temp`) AS minTemp',
                'AVG(`temp`) AS avgTemp',
            ]
        )->one();

        $weatherDataStatistics = new WeatherDataStatistics();
        $weatherDataStatistics->maximumTemperature = $res1['maxTemp'];
        $weatherDataStatistics->minimumTemperature = $res1['minTemp'];
        $weatherDataStatistics->averageTemperature = $res1['avgTemp'];


        $weatherDataEntityItems = $retrieveQuery
            ->limit($limit->getSize())
            ->offset($limit->getOffset())
            ->orderBy($this->getOrderExpression($order, function($param) { return $this->getOrderField($param);}))
            ->all();
        $weatherDataItems       = [];
        foreach ($weatherDataEntityItems as $item) {
            $weatherDataItems[] = $this->mapper->entityToContract($item);
        }

        $result->statistics = $weatherDataStatistics;
        $result->dataItems = $weatherDataItems;
        return $result;
    }

    public function getOrderField(OrderBase $ord) {
        switch($ord->getField() ) {
            case WeatherDataRetrieveOrder::ID:
                return 'id';
                break;
            case WeatherDataRetrieveOrder::TEMPERATURE:
                return 'temp';
                break;
            case WeatherDataRetrieveOrder::PRESSURE:
                return 'pressure';
                break;
            case WeatherDataRetrieveOrder::ALTITUDE:
                return 'alt';
                break;
        }
    }

    public function getIntervalsList()
    {
        return [
            WeatherDataBackIntervalEnum::LAST_TEN_MINUTES   => 'Last 10 minutes',
            WeatherDataBackIntervalEnum::LAST_FIRTH_MINUTES => 'Last 30 minutes',
            WeatherDataBackIntervalEnum::LAST_HOUR          => 'Last hour',
            WeatherDataBackIntervalEnum::LAST_THREE_HOURS   => 'Last 3 hours',
            WeatherDataBackIntervalEnum::LAST_HALF_DAY      => 'Last 12 hours',
            WeatherDataBackIntervalEnum::LAST_DAY           => 'Last day',
            WeatherDataBackIntervalEnum::LAST_THREE_DAYS    => 'Last 3 days',
            WeatherDataBackIntervalEnum::LAST_WEEK          => 'Last week',
        ];
    }
}