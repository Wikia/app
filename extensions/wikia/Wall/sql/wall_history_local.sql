CREATE TABLE wall_history (
	parent_page_id INT(8) UNSIGNED,
	post_user_id INT(10) UNSIGNED,
	post_user_ip_bin VARBINARY(16) DEFAULT NULL,
	is_reply tinyint(1),
	action tinyint(3),
	metatitle varchar(201),
	reason varchar(101),
	parent_comment_id INT(8) UNSIGNED,
	post_ns int(11) DEFAULT NULL,
	comment_id INT(8) UNSIGNED,
	revision_id INT(8) UNSIGNED,
	deleted_or_removed tinyint(1) DEFAULT 0,
	event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	key `getByParentPage` (parent_page_id, event_date),
	key `getByParentComment` (parent_comment_id, event_date),
	key `addStatChangeAction` (comment_id) 
) ENGINE=InnoDB;
