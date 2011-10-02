CREATE TABLE wall_notification (
	id INT(11) NOT NULL AUTO_INCREMENT,
	user_id INT(11) NOT NULL,
	wiki_id INT(11) NOT NULL,
	is_read INT(11) NOT NULL,
	is_reply INT(11) NOT NULL,
	author_id INT(11) NOT NULL,
	unique_id CHAR(30) NOT NULL,
	entity_key  CHAR(30) NOT NULL,
	KEY `unique_id` (unique),
	KEY `user` (user_id,wiki_id),
	PRIMARY KEY (id)
) ENGINE=InnoDB;