CREATE TABLE video_premigrate (
	id INT(11) NOT NULL AUTO_INCREMENT,
	img_name VARCHAR(255) NOT NULL,
	wiki_id INT(11) NOT NULL,
	provider VARCHAR(255) NOT NULL,
	new_metadata BLOB,
	is_name_taken INT(11) NOT NULL,
	api_url BLOB default NULL,
	video_id TINYBLOB default NULL,
	status INT(11) NOT NULL,
	status_msg BLOB default NULL,
	full_response BLOB default NULL,
	thumbnail_url VARCHAR(255) default NULL,
	backlinks INT(11) NOT NULL default 0,
	KEY `vp_wiki_img` (wiki_id,img_name),
	KEY `vp_prov` (provider),
	KEY `vp_nametaken` (is_name_taken),
	PRIMARY KEY (id)
) ENGINE=InnoDB;

// ALTER TABLE video_premigrate ADD api_url BLOB default NULL;
// ALTER TABLE video_premigrate ADD video_id INT(11) default NULL;
// ALTER TABLE video_premigrate MODIFY video_id TINYBLOB default NULL;
// ALTER TABLE video_premigrate ADD backlinks INT(11) NOT NULL default 0;