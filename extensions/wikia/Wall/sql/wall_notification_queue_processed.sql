CREATE TABLE wall_notification_queue_processed(
	user_id INT(11),
	entity_key  CHAR(30) NOT NULL,
	event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	KEY `wiki_id` (wiki_id, entity_key)
) ENGINE=InnoDB;