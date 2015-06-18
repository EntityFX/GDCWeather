<?php

namespace app\utils\helpers;

use DateTime;
use Yii;

class DateTimeHelper {

    private static $_englishMonthArray = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );
    private static $_englishWeekDaysArray = array(
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    );

    /**
     * @param DateTime $datetime
     * @param string $format
     * @return mixed
     */
    public static function format(DateTime $datetime, $format) {

        $nonNormalizedFormat = $datetime->format($format);

        return self::prepareDateTimeToLocal($nonNormalizedFormat);
    }

    private static function prepareDateTimeToLocal($timeString) {
        return str_replace(array_merge(self::$_englishMonthArray, self::$_englishWeekDaysArray), array_merge(Yii::app()->locale->getMonthNames(), Yii::app()->locale->getWeekDayNames()), $timeString);
    }

    /**
     * @param string $time
     * @param string $width
     * @return DateTime
     */
    public static function parseDateTime($time, $width = 'medium') {
        return DateTime::createFromFormat(self::getDateTimeFormat($width), self::prepareDateTimeToEnglish($time));
    }

    public static function parseFromDateAndTime($date, $time, $width = 'medium') {
        $formats       = self::getFormats();
        $localeFormats = $formats[Yii::$app->language];
        $fullDateTime =  str_replace(
            array('{1}', '{0}'),
            array($date, $time),
            $localeFormats['dateTimeFormat']
        );
        return self::parseDateTime($fullDateTime, $width);
    }

    /**
     * @param string $width
     * @return string
     */
    public static function getDateTimeFormat($width = 'medium') {
        $formats       = self::getFormats();
        $localeFormats = $formats[Yii::$app->language];

        return str_replace(
            array('{1}', '{0}'),
            array($localeFormats['dateFormats'][$width], $localeFormats['timeFormats'][$width]),
            $localeFormats['dateTimeFormat']
        );
    }

    private static function getFormats() {
        return array(
            'ru'    => array(
                'dateFormats'    => array(
                    'short'  => 'd.m.y',
                    'medium' => 'd.m.Y',
                    'long'   => 'j F Y г.',
                    'full'   => 'l, j F Y г.',
                ),
                'timeFormats'    => array(
                    'short'  => 'H:i',
                    'medium' => 'H:i:s',
                    'long'   => 'H:i:s T',
                    'full'   => 'H:i:s T',
                ),
                'dateTimeFormat' => '{1}, {0}'
            ),
            'ru_ru' => array(
                'dateFormats'    => array(
                    'short'  => 'd.m.y',
                    'medium' => 'd.m.Y',
                    'long'   => 'j F Y г.',
                    'full'   => 'l, j F Y г.',
                ),
                'timeFormats'    => array(
                    'short'  => 'H:i',
                    'medium' => 'H:i:s',
                    'long'   => 'H:i:s T',
                    'full'   => 'H:i:s T',
                ),
                'dateTimeFormat' => '{1}, {0}'
            ),
            'en'    => array(
                'dateFormats'    => array(
                    'short'  => 'n/j/y',
                    'medium' => 'M j, Y',
                    'long'   => 'F j, Y',
                    'full'   => 'l, F j, Y',
                ),
                'timeFormats'    => array(
                    'short'  => 'g:i A',
                    'medium' => 'g:i:s A',
                    'long'   => 'g:i:s A T',
                    'full'   => 'g:i:s A T',
                ),
                'dateTimeFormat' => '{1} {0}'
            )

        );
    }

    private static function prepareDateTimeToEnglish($timeString) {
        //TODO
        return '';
    }

    public static function parseDate($time, $width = 'medium') {
        $prepared = self::prepareDateTimeToEnglish($time);
        $dt = DateTime::createFromFormat(self::getDateFormat($width), $prepared);
        return $dt;
    }

    public static function getDateFormat($width = 'medium') {
        $formats = self::getFormats();

        return $formats[Yii::$app->language]['dateFormats'][$width];
    }

    public static function parseTime($time, $width = 'medium') {
        return DateTime::createFromFormat(self::getTimeFormat($width), self::prepareDateTimeToEnglish($time));
    }

    public static function getTimeFormat($width = 'medium') {
        $formats = self::getFormats();

        return $formats[Yii::$app->language]['timeFormats'][$width];
    }
}