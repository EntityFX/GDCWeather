<?php

namespace app\utils\helpers;
use DateTime;
use Traversable;

/**
 * Генерирует диапазон квартальных годов
 *
 * @author prozz <prozz.87@bk.com>
 */
class QuarterYearHelper
{
    const YEAR_STEP = 5;

    /**
     * @var int
     */
    private $_startYear;
    /**
     * @var int
     */
    private $_endYear;

    public static function create() {
        $currentDateTime = new DateTime();
        $currentYear = (int)$currentDateTime->format('Y');
        return new QuarterYearHelper($currentYear, $currentYear + self::YEAR_STEP);
    }

    public function __construct($startYear, $endYear)
    {
        $this->_startYear = (int)$startYear;
        $this->_endYear = (int)$endYear;
    }

    /**
     * @return Traversable
     */
    public function createList(){
        $list= new \ArrayObject();
        for ($year = $this->_startYear; $year <= $this->_endYear; ++$year) {
            for ($quarter = 1; $quarter <= 4; ++$quarter){
                $quarterYear = new QuarterYear();
                $quarterYear->year = $year;
                $quarterYear->quarter = $quarter;
                $list[] = $quarterYear;
            }
        }
        return $list;
    }

    public function getQuarterYearByIndex($index){
        $quarterYearList = $this->createList();
        return $quarterYearList[$index];
    }

}