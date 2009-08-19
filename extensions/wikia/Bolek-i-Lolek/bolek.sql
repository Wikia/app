CREATE TABLE IF NOT EXISTS bolek (
	b_id int unsigned NOT NULL auto_increment,
	b_user_id int NOT NULL,
	b_page_id int NOT NULL,
	b_timestamp int NOT NULL,
	PRIMARY KEY b_id (b_id),
	UNIQUE INDEX b_user_page (b_user_id, b_page_id),
	INDEX (b_user_id),
	INDEX (b_timestamp)
);

CREATE TABLE IF NOT EXISTS bolek_meta (
	bm_id int unsigned NOT NULL auto_increment,
	bm_user_id int NOT NULL,
	bm_cover text,
	bm_timestamp int NOT NULL,
	PRIMARY KEY bm_id (bm_id),
	UNIQUE INDEX bm_user (bm_user_id)
);
