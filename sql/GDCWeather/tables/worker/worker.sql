CREATE TABLE `Worker` (
  id               INT(11)     UNSIGNED      NOT NULL    AUTO_INCREMENT
  COMMENT 'Идентификатор скрипта выгрузки',
  `name`           VARCHAR(50)               NOT NULL
  COMMENT 'Имя скрипта выгрузки',
  class            VARCHAR(50)               NOT NULL
  COMMENT 'Класс скрипта выгрузки',
  `status`         TINYINT(4)                NOT NULL
  COMMENT 'Статус воркера',
  startDatetime    DATETIME                  NULL
  COMMENT 'Начало работы воркера',
  endDatetime      DATETIME                  NULL
  COMMENT 'Конец работы воркера',
  pid              INT(11)     UNSIGNED      NULL
  COMMENT 'PID процесса воркера',
  description      VARCHAR(100)              NULL
  COMMENT 'Описание',
  xmlConfiguration TEXT
                   COLLATE 'utf8_general_ci' NULL
  COMMENT 'XML конфигурация воркера',
  PRIMARY KEY (id)
)
  ENGINE = INNODB
  AUTO_INCREMENT = 1
  CHARACTER SET utf8
  COLLATE utf8_general_ci
  COMMENT = 'Таблица скриптов выгрузки';