CREATE TABLE `WorkerClientProxyXref` (
  workerId      INT(11)          UNSIGNED NOT NULL
  COMMENT 'Идентификатор скрипта выгрузки',
  clientProxyId INT(11)          UNSIGNED NOT NULL
  COMMENT 'Идентификатор прокси-клиента',
  PRIMARY KEY (workerId, clientProxyId),
  INDEX IX__workerId (workerId),
  INDEX IX__proxyId (clientProxyId),
  CONSTRAINT FK__worker_client_proxy_xref__worker_id FOREIGN KEY (workerId)
  REFERENCES Worker (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK__worker_client_proxy_xre__client_proxy_id FOREIGN KEY (clientProxyId)
  REFERENCES ClientProxy (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE = INNODB
  AUTO_INCREMENT = 1
  CHARACTER SET utf8
  COLLATE utf8_general_ci
  COMMENT = 'Таблица свизи worker : client_proxy - M : M';