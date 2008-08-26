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
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB;

create table if not exists rank_groups (
    grp_id int not null auto_increment primary key,
    grp_url varchar(255) not null,
    grp_keywords varchar(255) not null,
    grp_tm timestamp default now(),
    grp_active int not null default 1
) ENGINE=InnoDB;

create table if not exists rank_results (
    res_id int not null auto_increment primary key,
    res_id_grp int not null,
    res_engine int not null,
    res_position int not null,
    res_tm timestamp default now()
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

--
-- Social tools
--
CREATE TABLE IF NOT EXISTS `user_profile` (
  up_user_id int(7) NOT NULL default '0',
  up_location_city varchar(255) default NULL,
  up_location_state int(5) default NULL,
  up_location_country int(5) default NULL,
  up_hometown_city varchar(255) default NULL,
  up_hometown_state int(5) default NULL,
  up_hometown_country int(5) default NULL,
  up_birthday date default NULL,
  up_show_birthday int(2) default NULL,
  up_show_email int(2) default NULL,
  up_last_seen timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (up_user_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_relationship` (
  `r_id` int(11) NOT NULL auto_increment,
  `r_user_id` int(5) unsigned NOT NULL default '0',
  `r_user_name` varchar(255) NOT NULL default '',
  `r_user_id_relation` int(5) unsigned NOT NULL default '0',
  `r_user_name_relation` varchar(255) NOT NULL default '',
  `r_type` int(2) default NULL,
  `r_date` datetime default NULL,
  PRIMARY KEY  (`r_id`),
  KEY `r_user_id` (`r_user_id`),
  KEY `r_user_id_relation` (`r_user_id_relation`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_gift` (
  `ug_id` int(11) NOT NULL auto_increment,
  `ug_gift_id` int(5) unsigned NOT NULL default '0',
  `ug_user_id_to` int(5) unsigned NOT NULL default '0',
  `ug_user_name_to` varchar(255) NOT NULL default '',
  `ug_user_id_from` int(5) unsigned NOT NULL default '0',
  `ug_user_name_from` varchar(255) NOT NULL default '',
  `ug_status` int(2) default '1',
  `ug_type` int(2) default NULL,
  `ug_message` varchar(255) default NULL,
  `ug_date` datetime default NULL,
  PRIMARY KEY  (`ug_id`),
  KEY `ug_user_id_from` (`ug_user_id_from`),
  KEY `ug_user_id_to` (`ug_user_id_to`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `gift` (
  `gift_id` int(11) unsigned NOT NULL auto_increment,
  `gift_name` varchar(255) NOT NULL default '',
  `gift_description` text,
  `gift_given_count` int(5) default '0',
  `gift_createdate` datetime default NULL,
  PRIMARY KEY  (`gift_id`)
) ENGINE=InnoDB;
ALTER TABLE `gift` AUTO_INCREMENT = 50000;

CREATE TABLE  IF NOT EXISTS `user_relationship_stats` (
  `rs_id` int(11) NOT NULL auto_increment,
  `rs_user_id` int(5) unsigned NOT NULL default '0',
  `rs_user_name` varchar(255) NOT NULL default '',
  `rs_friend_count` int(11) unsigned NOT NULL default '0',
  `rs_foe_count` int(11) unsigned NOT NULL default '0',
  `rs_requests_in_count` int(11) unsigned NOT NULL default '0',
  `rs_requests_out_count` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rs_id`),
  KEY `rs_user_id` (`rs_user_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_relationship_request` (
  `ur_id` int(11) NOT NULL auto_increment,
  `ur_user_id_from` int(5) unsigned NOT NULL default '0',
  `ur_user_name_from` varchar(255) NOT NULL default '',
  `ur_user_id_to` int(5) unsigned NOT NULL default '0',
  `ur_user_name_to` varchar(255) NOT NULL default '',
  `ur_status` int(2) default '0',
  `ur_type` int(2) default NULL,
  `ur_message` varchar(255) default NULL,
  `ur_date` datetime default NULL,
  PRIMARY KEY  (`ur_id`),
  KEY `ur_user_id_from` (`ur_user_id_from`),
  KEY `ur_user_id_to` (`ur_user_id_to`)
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
