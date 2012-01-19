CREATE TABLE wall_history (
	wall_user_id INT(11),
	wall_user_ip varchar(16),
	wiki_id INT(11),
	post_user_id INT(11),
	post_user_ip varchar(16),
	is_reply INT(1),
	action INT(3),
	metatitle varchar(201),
	reason varchar(101),
	page_id INT(11),
	reason varchar(100),
	parent_page_id INT(11),
	event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	KEY `wlh` (wall_user_id,wiki_id),
	KEY `tlh` (parent_page_id,wiki_id)
) ENGINE=InnoDB;