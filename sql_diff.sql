
CREATE  DATABASE task_pro;
DROP TABLE IF EXISTS `sub_task`;
CREATE TABLE `sub_task` (
  `id_subtask` int(10) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_delete` enum('Y','N') NOT NULL DEFAULT 'N',
  `is_completed` enum('Y','N') NOT NULL DEFAULT 'N',
  `due-date` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id_subtask`),
  KEY `id` (`id`),
  CONSTRAINT `sub_task_ibfk_1` FOREIGN KEY (`id`) REFERENCES `task` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `is_delete` enum('Y','N') NOT NULL DEFAULT 'N',
  `is_completed` enum('Y','N') NOT NULL DEFAULT 'N',
  `due-date` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
