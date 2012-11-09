CREATE TABLE wall_history (
	parent_page_id INT(10),
	post_user_id INT(10),
	post_user_ip varchar(16),
	is_reply INT(1),
	action INT(3),
	metatitle varchar(201),
	reason varchar(101),
	parent_comment_id INT(10),
	post_ns int(11) DEFAULT NULL,
	comment_id INT(10),
	revision_id INT(11),
	deleted_or_removed int(1) DEFAULT 0,
	event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	key `getLastUsers` (action, post_ns, deleted_or_removed),
	key `getByParentPage` (parent_page_id, event_date),
	key `getByParentComment` (parent_comment_id, event_date)
) ENGINE=InnoDB;