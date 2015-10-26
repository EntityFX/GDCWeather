CREATE TABLE `ClientProxyEndpoint` (
  id        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT
  COMMENT 'Id конечной точки прокси-клиента',
  url       VARCHAR(255)     NOT NULL
  COMMENT 'Url-адрес конечной точки',
  `version` TINYINT(4)       NULL
  COMMENT 'Версия конечной точки',
  proxyId   INT(11) UNSIGNED NOT NULL
  COMMENT 'Id клиентского прокси',
  PRIMARY KEY (id),
  CONSTRAINT FK__ClientProxyEndpoint__id FOREIGN KEY (proxyId)
  REFERENCES ClientProxy (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = INNODB
  AUTO_INCREMENT = 1
  CHARACTER SET utf8
  COLLATE utf8_general_ci
  COMMENT = 'Таблица прокси клиентов';