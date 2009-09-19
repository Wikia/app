CREATE TABLE IF NOT EXISTS bolek (
	b_id int unsigned NOT NULL auto_increment,
	b_bolek_id char(32) NOT NULL,
	b_page_id int NOT NULL,
	b_timestamp int NOT NULL,
	PRIMARY KEY b_id (b_id),
	UNIQUE INDEX b_bolek_page (b_bolek_id, b_page_id),
	INDEX (b_bolek_id),
	INDEX (b_timestamp)
);

CREATE TABLE IF NOT EXISTS bolek_meta (
	bm_id int unsigned NOT NULL auto_increment,
	bm_bolek_id char(32) NOT NULL,
	bm_cover text,
	bm_timestamp int NOT NULL,
	bm_user_id int unsigneder_id int unsigned NOT NULL
	bm_user_name varchar(255)
	PRIMARY KEY bm_id (bm_id),
	UNIQUE INDEX bm_bolek (bm_bolek_id)
);
