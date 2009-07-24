--
-- This file should only contain Wikia-specific tables,
-- which are meant to be created in _local_ databases.

-- Note that this file is subject to move to /wikia subdirectory.

CREATE TABLE IF NOT EXISTS `imagetags` (
  `unique_id` int(10) unsigned NOT NULL auto_increment,
  `img_page_id` int(10) unsigned NOT NULL,
  `img_name` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `article_tag` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  `tag_rect` varchar(30) character set ascii collate ascii_bin NOT NULL,
  `user_text` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`unique_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `page_vote` (
  `article_id` int(8) unsigned NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `unique_id` varchar(32) NOT NULL DEFAULT '',
  `vote` int(2) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `time` datetime NOT NULL,
  KEY `user_id` (`user_id`,`article_id`),
  KEY `article_id` (`article_id`),
  KEY `unique_vote` (`unique_id`, `article_id`)
) ENGINE=InnoDB;


create table if not exists send_stats (
    send_id int not null auto_increment primary key,
    send_page_id int not null,
    send_page_ns int not null,
    send_page_re int not null,
    send_unique int not null,
    send_tm timestamp default now(),
    send_ip varchar(16) not null,
    send_to mediumtext not null,
    send_from varchar(255) not null,
    send_name varchar(255) not null,
    send_user varchar(255) not null,
    send_ajax int not null,
    send_seen int not null default 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `page_visited` (
  `article_id` int(9) not null,
  `count` int(8) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `page_visited_cnt_inx` (`count`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `poll_info` (
		`poll_id` VARCHAR(32),
		`poll_txt` TEXT,
		`poll_date` DATETIME,
		`poll_title` VARCHAR(255),
		`poll_domain` VARCHAR(10),
		PRIMARY KEY  (`poll_id`)
) Engine=InnoDB;

CREATE TABLE IF NOT EXISTS `poll_vote` (
		`poll_id` VARCHAR(32),
		`poll_user` VARCHAR(255),
		`poll_ip` VARCHAR(255),
		`poll_answer` INTEGER(3),
		`poll_date` DATETIME,
			PRIMARY KEY  (`poll_id`,`poll_user`)
) Engine=InnoDB;
