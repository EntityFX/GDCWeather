CREATE TABLE WeatherPollingData (
    id binary(16) NOT NULL,
    temp decimal(3, 1) NOT NULL,
    pressure int(11) NOT NULL,
    alt double NOT NULL,
    dateTime datetime NOT NULL,
    sensorId BINARY(16) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_WeatherPollingData_Sensor_id FOREIGN KEY (sensorId)
    REFERENCES Sensor (id)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT
)
    ENGINE = INNODB
    AUTO_INCREMENT = 1
    CHARACTER SET utf8
    COLLATE utf8_general_ci;