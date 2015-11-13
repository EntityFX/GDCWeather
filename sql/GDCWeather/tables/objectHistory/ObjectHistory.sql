CREATE TABLE ObjectHistory (
  id             BINARY(16)           NOT NULL
  COMMENT 'Идентификатор объекта',
  category       TINYINT(4) UNSIGNED  NOT NULL
  COMMENT 'Тип операции',
  `type`         SMALLINT(6) UNSIGNED NOT NULL
  COMMENT 'Типы объектов: переичсление',
  changeDateTime DATETIME DEFAULT NULL
  COMMENT 'Дата добавления',
  priority       TINYINT(3) UNSIGNED  NOT NULL
  COMMENT 'Приоритет',
  PRIMARY KEY (id)
)
  ENGINE = INNODB
  COMMENT = 'Отслеживает изменения всех объектов';