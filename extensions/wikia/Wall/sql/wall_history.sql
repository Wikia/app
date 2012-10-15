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
	revision_id INT(11),
	event_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	KEY `w_wip_pid_ed` (wiki_id, wall_user_ip, page_id, event_date),
	KEY `w_wid_pid_ed` (wiki_id, wall_user_id, page_id, event_date),
	KEY `w_wip_ppid_ed` (wiki_id, wall_user_ip, parent_page_id, event_date),
	KEY `w_wid_ppid_ed` (wiki_id, wall_user_id, parent_page_id, event_date)
) ENGINE=InnoDB;


ALTER TABLE wall_history DROP KEY wlh;
ALTER TABLE wall_history DROP KEY tlh;
ALTER TABLE wall_history ADD KEY `w_wip_pid_ed` (wiki_id, wall_user_ip, page_id, event_date);
ALTER TABLE wall_history ADD KEY `w_wid_pid_ed` (wiki_id, wall_user_id, page_id, event_date);
ALTER TABLE wall_history ADD KEY `w_wip_ppid_ed` (wiki_id, wall_user_ip, parent_page_id, event_date);
ALTER TABLE wall_history ADD KEY `w_wid_ppid_ed` (wiki_id, wall_user_id, parent_page_id, event_date);

ALTER TABLE wall_history ADD KEY `w_wip_ns_user` (wiki_id, post_ns, event_date, post_user_id);
ALTER TABLE wall_history ADD KEY `w_wip_ns_page` (wiki_id, page_id);

alter table wall_history add post_ns int(11) DEFAULT NULL;
alter table wall_history add deleted_or_removed int(1) DEFAULT 0;