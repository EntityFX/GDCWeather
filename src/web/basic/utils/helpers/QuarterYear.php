<?php

namespace app\utils\helpers;
use yii\base\Component;
use app\utils\exceptions\ValidationException;

/**
 * Class QuarterYear
 * @property int $year Год в квартале
 * @property int $quarter квартал
 */
class QuarterYear extends Component  {
    /**
     * @var int
     */
    private $_year;

    /**
     * @param int $year
     * @throws ValidationException
     * @throws ValidationException
     */
    public function setYear($year)
    {
        if ($year < 1901 && $year >= 2100) {
            throw new ValidationException("Year incorrect");
        }
        $this->_year = (int)$year;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->_year;
    }

    private $_quarter;
    /**
     * @param $quarter
     * @throws ValidationException
     */
    public function setQuarter($quarter)
    {
        if ($quarter < 1 && $quarter > 4) {
            throw new ValidationException("Quarter incorrect");
        }
        $this->_quarter = (int)$quarter;
    }
    /**
     * @return int
     */
    public function getQuarter()
    {
        return $this->_quarter;
    }

    public function __toString() {
        return $this->_quarter . ' квартал ' . $this->year . ' г.';
    }
}