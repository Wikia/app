CREATE TABLE wall_notification_queue (
	wiki_id INT(11),
	page_id INT(11),
	entity_key  CHAR(30) NOT NULL,
	event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (wiki_id, page_id),
	KEY `wiki_id` (wiki_id)
) ENGINE=InnoDB;