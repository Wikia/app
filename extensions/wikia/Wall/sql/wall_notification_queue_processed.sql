CREATE TABLE `wall_notification_queue_processed` (
  `user_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `user_event_idx` (`user_id`,`entity_key`)
) ENGINE=InnoDB;
