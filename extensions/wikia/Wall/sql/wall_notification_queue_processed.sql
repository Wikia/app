CREATE TABLE `wall_notification_queue_processed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_event_idx` (`user_id`,`entity_key`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;