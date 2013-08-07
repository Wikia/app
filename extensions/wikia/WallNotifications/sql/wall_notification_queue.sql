# this table stored notifications for highlighted threads

CREATE TABLE `wall_notification_queue` (
  `wiki_id` int(10) unsigned NOT NULL,    # wiki/city identifier
  `entity_key` varbinary(30) NOT NULL,    # the same as entity_key in wall_notification table
  `page_id` int(10) unsigned NOT NULL DEFAULT '0', # article identifier
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`page_id`)
) ENGINE=InnoDB;
