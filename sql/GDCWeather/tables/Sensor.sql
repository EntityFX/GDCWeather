CREATE TABLE Sensor (
    id binary(16) NOT NULL,
    name varchar(50) NOT NULL,
    model varchar(255) NOT NULL,
    vendorId binary(16) NOT NULL,
    type int(10) UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_Sensor_SensorType_id FOREIGN KEY (type)
    REFERENCES SensorType (id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT FK_Sensor_SensorVendor_id FOREIGN KEY (vendorId)
    REFERENCES SensorVendor (id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;