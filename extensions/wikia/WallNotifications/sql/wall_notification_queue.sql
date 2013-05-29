CREATE TABLE `wall_notification_queue` (
  `wiki_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `page_id` int(10) unsigned DEFAULT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`, `page_id`)
) ENGINE=InnoDB;
