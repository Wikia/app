CREATE TABLE video_imagetable_backup (
	id INT(11) NOT NULL AUTO_INCREMENT,
	wiki_id INT(11) NOT NULL,
	img_name varchar(255),
	img_metadata mediumblob,
	img_user int(5) unsigned,
	img_user_text varchar(255),
	img_timestamp char(14),
	KEY `vitb_wiki` (wiki_id),
	PRIMARY KEY (id)
) ENGINE=InnoDB;