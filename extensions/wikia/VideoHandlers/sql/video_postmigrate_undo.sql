// table for UNDO data, needed to reverse postmigration (article namespace migration)

CREATE TABLE video_postmigrate_undo (
	id INT(11) NOT NULL AUTO_INCREMENT,
	wiki_id INT(11) NOT NULL,
	entry_table VARCHAR(255) NOT NULL,
	entry_id VARCHAR(255) NOT NULL,
	entry_id_field VARCHAR(255) NOT NULL,
	entry_ns_field VARCHAR(255) NOT NULL,
	KEY `vpu_wiki_id` (wiki_id),
	PRIMARY KEY (id)
) ENGINE=InnoDB;


// ALTER TABLE video_postmigrate_undo ADD entry_table VARCHAR(255) NOT NULL;
