CREATE TABLE bolek (
	b_id int unsigned NOT NULL auto_increment,
	b_user_id int NOT NULL,
	b_page_id int NOT NULL,
	b_timestamp int NOT NULL,
	PRIMARY KEY b_id (b_id),
	UNIQUE INDEX user_page (b_user_id, b_page_id),
	INDEX (b_user_id),
	INDEX (b_timestamp)
);
