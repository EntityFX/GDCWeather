<?php

\Yii::$container->set(
    'app\businessLogic\contracts\weatherData\WeatherDataManagerInterface',
    'app\businessLogic\implementation\weatherData\FakeWeatherDataManager'
);