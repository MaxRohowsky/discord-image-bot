CREATE TABLE `Counter` (
  `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Number` int NOT NULL,
  UNIQUE KEY `Number` (`Number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3