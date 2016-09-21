CREATE TABLE IF NOT EXISTS founder_emails_event (
 feev_id INT(11) NOT NULL AUTO_INCREMENT,
 feev_wiki_id INT(11) NOT NULL,
 feev_timestamp VARCHAR(14) default NULL,
 feev_type VARCHAR(32),
 feev_data BLOB NOT NULL,
 PRIMARY KEY (`feev_id`),
 KEY `feev_wiki_id` (`feev_wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
