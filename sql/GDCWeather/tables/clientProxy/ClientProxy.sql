CREATE TABLE `ClientProxy` (
  id       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT 'Id прокси-клиента',
  contract VARCHAR(50)      NOT NULL
  COMMENT 'Имя контраката прокси клиента',
  type     TINYINT(4)       NOT NULL
  COMMENT 'Тип прокси',
  PRIMARY KEY (id)
)
  ENGINE = INNODB
  AUTO_INCREMENT = 1
  CHARACTER SET utf8
  COLLATE utf8_general_ci
  COMMENT = 'Таблица прокси клиентов';