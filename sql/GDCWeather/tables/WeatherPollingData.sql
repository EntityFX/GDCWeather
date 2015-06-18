CREATE TABLE GDCWeather.WeatherPollingData (
    id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    temp decimal(3, 1) NOT NULL,
    pressure int(11) NOT NULL,
    alt double NOT NULL,
    dateTime datetime NOT NULL,
    PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;