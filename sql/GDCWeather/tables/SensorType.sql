CREATE TABLE SensorType (
    id int(11) UNSIGNED NOT NULL,
    value varchar(50) NOT NULL,
    description varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE INDEX id (id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci;