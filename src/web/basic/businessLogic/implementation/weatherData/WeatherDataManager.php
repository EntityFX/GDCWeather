<?php

namespace app\businessLogic\implementation\weatherData;

use app\businessLogic\contracts\ContractObjectHistoryCategoryEnum;
use app\businessLogic\contracts\weatherData\enums\WeatherDataBackIntervalEnum;
use app\businessLogic\contracts\weatherData\filters\WeatherDataRetrieveFilter;
use app\businessLogic\contracts\weatherData\ordering\WeatherDataRetrieveOrder;
use app\businessLogic\contracts\weatherData\WeatherChartItem;
use app\businessLogic\contracts\weatherData\WeatherDataItem;
use app\businessLogic\contracts\weatherData\WeatherDataManagerInterface;
use app\businessLogic\contracts\weatherData\WeatherDataRetrieveResult;
use app\businessLogic\contracts\weatherData\WeatherDataStatistics;
use app\businessLogic\implementation\weatherData\mapper\WeatherDataMapper;
use app\dataAccess\entities\WeatherPollingDataEntity;
use entityfx\utils\exceptions\ManagerException;
use entityfx\utils\objectHistory\contracts\enums\HistoryTypeEnum;
use entityfx\utils\objectHistory\ObjectHistory;
use entityfx\utils\objectHistory\ObjectHistoryEvent;
use entityfx\utils\order\OrderBase;
use DateTime;
use entityfx\utils\Limit;
use entityfx\utils\ManagerBase;
use Yii;
use yii\base\Exception;
use yii\db\IntegrityException;
use yii\db\Query;

class WeatherDataManager extends ManagerBase implements WeatherDataManagerInterface
{

    private $_intervalMap = [
        WeatherDataBackIntervalEnum::LAST_HOUR => '-1 hour',
        WeatherDataBackIntervalEnum::LAST_THREE_HOURS => '-3 hours',
        WeatherDataBackIntervalEnum::LAST_SIX_HOURS => '-6 hours',
        WeatherDataBackIntervalEnum::LAST_HALF_DAY => '-12 hours',
        WeatherDataBackIntervalEnum::LAST_DAY => '-1 day',
        WeatherDataBackIntervalEnum::LAST_WEEK => '-1 week',
        WeatherDataBackIntervalEnum::LAST_YEAR => '-1 year',
    ];

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param WeatherDataRetrieveFilter $filter
     *
     * @param \entityfx\utils\Limit $limit
     * @param WeatherDataRetrieveOrder $order
     *
     * @return WeatherDataRetrieveResult
     */
    public function retrieve(WeatherDataRetrieveFilter $filter, Limit $limit, WeatherDataRetrieveOrder $order)
    {
        $result = new WeatherDataRetrieveResult();

        $lastDataItem = WeatherPollingDataEntity::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->one();

        if ($lastDataItem != null) {
            $result->lastMeasure = $this->mapper->entityToContract($lastDataItem);
        }

        $retrieveQuery = WeatherPollingDataEntity::find();


        $dateTimeInterval = $this->prepareDateTimeInterval($filter);

        $fromDateTimeFormatted = $dateTimeInterval['fromDateTime']->format('Y-m-d H:i:s');
        $toDateTimeFormatted = $dateTimeInterval['toDateTime']->format('Y-m-d H:i:s');
        $retrieveQuery = $retrieveQuery->where(
            ['between', 'dateTime', $fromDateTimeFormatted, $toDateTimeFormatted]
        );

        $statisticsQuery = $retrieveQuery->prepare(new Query());
        $statisticsResult = $statisticsQuery->select(
            [
                'MAX(`temp`) AS maxTemp',
                'MIN(`temp`) AS minTemp',
                'AVG(`temp`) AS avgTemp',
                'MAX(`pressure`) AS maxPressure',
                'MIN(`pressure`) AS minPressure',
                'AVG(`pressure`) AS avgPressure',
            ]
        )->one();

        $weatherDataStatistics = new WeatherDataStatistics();
        $weatherDataStatistics->maximumTemperature = $statisticsResult['maxTemp'];
        $weatherDataStatistics->minimumTemperature = $statisticsResult['minTemp'];
        $weatherDataStatistics->averageTemperature = $statisticsResult['avgTemp'];
        $weatherDataStatistics->maximumPressure = $statisticsResult['maxPressure'];
        $weatherDataStatistics->minimumPressure = $statisticsResult['minPressure'];
        $weatherDataStatistics->averagePressure = $statisticsResult['avgPressure'];


        $countQuery = $retrieveQuery->prepare(new Query());
        $countItems = $countQuery->count();


        $weatherDataEntityItems = $retrieveQuery
            ->limit($limit->getSize())
            ->offset($limit->getOffset())
            ->orderBy(
                $this->getOrderExpression(
                    $order, function ($param) {
                    return $this->getOrderField($param);
                }
                )
            )
            ->all();
        $weatherDataItems = [];
        foreach ($weatherDataEntityItems as $item) {
            $weatherDataItems[] = $this->mapper->entityToContract($item);
        }

        $result->statistics = $weatherDataStatistics;
        $result->dataItems = $weatherDataItems;
        $result->totalItems = $countItems;

        return $result;
    }

    public function getOrderField(OrderBase $ord)
    {
        switch ($ord->getField()) {
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
            WeatherDataBackIntervalEnum::LAST_HOUR => 'Last hour',
            WeatherDataBackIntervalEnum::LAST_THREE_HOURS => 'Last 3 hours',
            WeatherDataBackIntervalEnum::LAST_SIX_HOURS => 'Last 6 hours',
            WeatherDataBackIntervalEnum::LAST_HALF_DAY => 'Last 12 hours',
            WeatherDataBackIntervalEnum::LAST_DAY => 'Last day',
            WeatherDataBackIntervalEnum::LAST_WEEK => 'Last week',
            WeatherDataBackIntervalEnum::LAST_YEAR => 'Last year',
        ];
    }

    /**
     * @param WeatherDataRetrieveFilter $filter
     * @return \app\businessLogic\contracts\weatherData\WeatherChartItem[]
     */
    function retrieveChartData(WeatherDataRetrieveFilter $filter)
    {
        $result = [];

        $weatherDataTableName = WeatherPollingDataEntity::tableName();

        $sql = <<<SQL
            SELECT
                TimeRange,
                TIMESTAMPADD(SECOND, TimeRange * TIMESTAMPDIFF(SECOND, :from, :to) / :countPoints, :from) TimeRangeStart,
                TIMESTAMPADD(SECOND, (TimeRange+1) * TIMESTAMPDIFF(SECOND, :from, :to) / :countPoints, :from) TimeRangeEnd,
                AVG(t2.temp) AverageTemperature,
                AVG(t2.pressure) AveragePressure,
                MAX(t2.temp) MaximumTemperature,
                MAX(t2.pressure) MaximumPressure,
                MIN(t2.temp) MinimumTemperature,
                MIN(t2.pressure) MinimumPressure
            FROM (
                SELECT
                    *,
                    FLOOR(TIMESTAMPDIFF(SECOND, :from, dateTime) / (TIMESTAMPDIFF(SECOND, :from, :to) / :countPoints) * 0.999999) TimeRange
                FROM (
                    SELECT
                        *
                    FROM {$weatherDataTableName} wpd
                    WHERE wpd.dateTime BETWEEN :from AND :to
                ) t
            ) t2
            GROUP BY TimeRange
SQL;

        $dateTimeInterval = $this->prepareDateTimeInterval($filter);

        $dbCommand = Yii::$app->db->createCommand($sql)
            ->bindValue(':from', $dateTimeInterval['fromDateTime']->format('Y-m-d H:i:s'))
            ->bindValue(':to', $dateTimeInterval['toDateTime']->format('Y-m-d H:i:s'))
            ->bindValue(':countPoints', $filter->countPoints);


        $dbRes = $dbCommand->queryAll();
        $result = [];
        /** @var WeatherPollingDataEntity $item */
        foreach ($dbRes as $item) {
            $resItem = new WeatherChartItem();
            $resItem->key = $item['TimeRange'];
            $resItem->startDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $item['TimeRangeStart']);
            $resItem->endDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $item['TimeRangeEnd']);
            $resItem->averageTemperature = $item['AverageTemperature'];
            $resItem->maximumTemperature = $item['MaximumTemperature'];
            $resItem->minimumTemperature = $item['MinimumTemperature'];
            $resItem->averagePressure = $item['AveragePressure'];
            $result[] = $resItem;
        }

        return $result;
    }

    function create(WeatherDataItem $weatherData)
    {
        $weatherEntity = $this->mapper->contractToEntity($weatherData);
        try {
            $weatherEntity->save();
        } catch (\Exception $exception) {
            throw new ManagerException("Cannot create weather data item", "", "", $exception);
        }

        $this->triggerComponentEvent(
            ObjectHistory::EVENT_OBJECT_CHANGED,
            new ObjectHistoryEvent(
                new HistoryTypeEnum(HistoryTypeEnum::CREATE),
                $weatherData->id,
                ContractObjectHistoryCategoryEnum::WEATHER_SENSOR_DATA
            ), Yii::$app->objectHistory);

        return $weatherData;
    }

    protected function initMapper()
    {
        return new WeatherDataMapper();
    }

    private function prepareDateTimeInterval(WeatherDataRetrieveFilter $filter) {
        $toDateTime   = clone $filter->startDateTime;
        $fromDateTime = clone $filter->startDateTime;
        $fromDateTime->add(
            \DateInterval::createFromDateString(
                $this->_intervalMap[$filter->backInterval->getValue()]
            )
        );

        return [
            'fromDateTime' => $fromDateTime,
            'toDateTime' => $toDateTime
        ];
    }
}