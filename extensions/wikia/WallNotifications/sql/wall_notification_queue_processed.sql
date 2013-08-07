#This stored information about the highlighted notification that were already processed for a given user

CREATE TABLE `wall_notification_queue_processed` (
  `user_id` int(10) unsigned NOT NULL,  # identifier of the user that received a notification
  `entity_key` varbinary(30) NOT NULL,  # notification identifier, the same as wall_notification.entity_key
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `user_event_idx` (`user_id`,`entity_key`)
) ENGINE=InnoDB;
