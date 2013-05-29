CREATE TABLE wall_notification (
	id INT(11) NOT NULL AUTO_INCREMENT,
	user_id INT(11) NOT NULL,
	wiki_id INT(11),
	is_read INT(11) NOT NULL,
	is_reply INT(11) NOT NULL,
	is_hidden INT(11) NOT NULL DEFAULT 0,
	author_id INT(11) NOT NULL,
	unique_id INT(11) NOT NULL,
	entity_key  CHAR(30) NOT NULL,
	notif_type INT(11) DEFAULT 0,
	KEY `user` (user_id,wiki_id),
	KEY `user_wiki_unique` (user_id,wiki_id,unique_id),
	PRIMARY KEY (id)
) ENGINE=InnoDB;


// ALTER TABLE wall_notification MODIFY unique_id INT(11) NOT NULL;
// ALTER TABLE wall_notification ADD is_hidden INT(11) NOT NULL DEFAULT 0;
// ALTER TABLE wall_notification ADD KEY `user_wiki_unique` (user_id,wiki_id,unique_id);
// alter table wall_notification add notifyeveryone  INT(1) NOT NULL DEFAULT 0;