CREATE TABLE SensorVendor (
    id binary(16) NOT NULL,
    name varchar(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE INDEX UK_SensorVendor_name (name)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 780
CHARACTER SET utf8
COLLATE utf8_general_ci;