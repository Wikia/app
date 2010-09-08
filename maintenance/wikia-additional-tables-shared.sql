-- This file should only contain Wikia-specific tables,
-- which are meant to be created in _shared_ databases.

-- Initial data should also be put here.

-- Note that this file is subject to move to /wikia subdirectory.


create table if not exists jabstatus (
  id int not null auto_increment primary key,
  wikia varchar(200) not null,
  user int not null default 0,
  jid varchar(50) not null,
  status varchar(10) not null,
  presence char(1) not null default 'A'
) ENGINE=InnoDB;

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
  `gift_id` int(11) NOT NULL auto_increment,
  `gift_name` varchar(255) NOT NULL default '',
  `gift_description` text,
  `gift_given_count` int(5) default '0',
  `gift_createdate` datetime default NULL,
  PRIMARY KEY  (`gift_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `user_relationship_stats` (
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

CREATE TABLE IF NOT EXISTS `facebook_users` (
  `fu_user_id` int(10) unsigned NOT NULL,
  `fu_subscribed` varchar(255) default NULL,
  PRIMARY KEY  (`fu_user_id`)
) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `wikia_tasks` (
  `task_id` int(11) NOT NULL auto_increment,
  `task_user_id` int(5) unsigned NOT NULL default '0',
  `task_type` varchar(255) NOT NULL default '',
  `task_priority` tinyint(4) NOT NULL default '0',
  `task_status` tinyint(4) NOT NULL default '0',
  `task_started` char(14) NOT NULL,
  `task_finished` char(14) NOT NULL,
  `task_arguments` text,
  `task_log` text,
  `task_added` char(14) NOT NULL,
  PRIMARY KEY  (`task_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `wikia_tasks_log` (
  `task_id` int(11) NOT NULL,
  `log_timestamp` char(14) NOT NULL,
  `log_line` text NOT NULL,
  KEY `new_fk_constraint` (`task_id`),
  CONSTRAINT `new_fk_constraint` FOREIGN KEY (`task_id`) REFERENCES `wikia_tasks` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `shout_box_messages` (
  `id` int(11) NOT NULL auto_increment,
  `city` int(9) default NULL,
  `wikia` varchar(200) default NULL,
  `user` int(11) default NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `message` text,
  PRIMARY KEY  (`id`),
  KEY `wikia_idx` (`wikia`),
  KEY `city_idx` (`city`)
) ENGINE=InnoDB;

-- Additional table for the SharedUserrights extension
-- To be added to $wgSharedDB

CREATE TABLE IF NOT EXISTS `shared_user_groups` (
  `sug_user` int(5) unsigned NOT NULL default '0',
  `sug_group` char(16) NOT NULL default '',
  PRIMARY KEY  (`sug_user`,`sug_group`),
  KEY `sug_group` (`sug_group`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `city_list_requests_lock` (
  `id` int(11) NOT NULL auto_increment,
  `request_id` int(11) default NULL,
  `user_id` int(9) unsigned default NULL,
  `locked` int(1) NOT NULL default '1',
  `timestamp` varchar(14) default '19700101000000',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

-- RegexBlock [coppied from extensions/wikia/RegexBlock/blockedby.sql]
CREATE TABLE IF NOT EXISTS `blockedby` (
  `blckby_id` int(5) NOT NULL auto_increment,
  `blckby_name` varchar(255) character set latin1 collate latin1_general_cs NOT NULL,
  `blckby_blocker` varchar(255) character set latin1 collate latin1_general_cs NOT NULL,
  `blckby_timestamp` char(14) NOT NULL,
  `blckby_expire` char(14) NOT NULL,
  `blckby_create` tinyint(1) NOT NULL default '1',
  `blckby_exact` tinyint(1) NOT NULL default '0',
  `blckby_reason` tinyblob NOT NULL,
  PRIMARY KEY  (`blckby_id`),
  UNIQUE KEY `blckby_name` (`blckby_name`),
  KEY `blckby_timestamp` (`blckby_timestamp`),
  KEY `blckby_expire` (`blckby_expire`),
  KEY `blockeridx` (`blckby_blocker`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `blockedby_stats` (
  `stats_id` int(8) NOT NULL auto_increment,
  `stats_blckby_id` int(8) NOT NULL,
  `stats_user` varchar(255) NOT NULL,
  `stats_blocker` varchar(255) NOT NULL,
  `stats_timestamp` char(14) NOT NULL,
  `stats_ip` char(15) NOT NULL,
  `stats_match` varchar(255) NOT NULL default '',
  `stats_dbname` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`stats_id`),
  KEY `stats_blckby_id_key` (`stats_blckby_id`),
  KEY `stats_timestamp` (`stats_timestamp`)
) ENGINE=InnoDB;

-- SiteWideMessages [copied from extensions/wikia/SiteWideMessages/schema.sql]
-- Message textdata
CREATE TABLE IF NOT EXISTS `messages_text`
(
	`msg_id`              int (7)  unsigned   NOT NULL    auto_increment,
	`msg_sender_id`       int (10) unsigned   NOT NULL,
	`msg_text`            mediumtext          NOT NULL,
	`msg_mode`            tinyint             NOT NULL    default 0,
	`msg_removed`         tinyint             NOT NULL    default 0,
	`msg_expire`          datetime,
	`msg_date`            timestamp           NOT NULL    default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	`msg_recipient_name`  varchar (255),				#only for displaying in the history
	`msg_group_name`      varchar (255),				#only for displaying in the history
	`msg_wiki_name`       varchar (255),				#only for displaying in the history
	`msg_hub_id`          int (9),
	PRIMARY KEY (`msg_id`)
);
-- msg_mode: 0 = all users, 1 = selected users

-- Messages metadata
CREATE TABLE IF NOT EXISTS `messages_status`
(
	`msg_wiki_id`      int (9),
	`msg_recipient_id` int (10) unsigned,				#NULL -> message to ALL users
	`msg_id`           int (7)  unsigned   NOT NULL,
	`msg_status`       tinyint             NOT NULL,
	`msg_date`         timestamp           NOT NULL    default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	PRIMARY KEY (`msg_recipient_id`, `msg_id`),
	KEY `msg_id` (`msg_id`)
);

-- msg_status: 0 = unseen, 1 = seen, 2 = dismissed

-- WhosOnline - moved from per wiki to shared DB
CREATE TABLE IF NOT EXISTS `online` (
        `userid` int(5) NOT NULL default '0',
        `username` varchar(255) NOT NULL default '',
        `timestamp` char(14) NOT NULL default '',
		`wikiid` int (9),
	PRIMARY KEY USING HASH (`userid`, `username`),
	INDEX USING BTREE (`timestamp`)
) TYPE=InnoDB;

-- user wikicities aint got enough rights to do views! ops need to be asked to run this query
-- CREATE OR REPLACE VIEW city_cats_view AS SELECT city_id AS cc_city_id, cat_name AS cc_name FROM city_cats, city_cat_mapping WHERE city_cats.cat_id = city_cat_mapping.cat_id;

CREATE TABLE IF NOT EXISTS `magic_footer_links` (
  `dbname` varchar(31) NOT NULL,
  `page` varchar(255) NOT NULL,
  `links` mediumblob NOT NULL,
  KEY `dbname` (`dbname`,`page`)
) ENGINE=InnoDB;

-- SharedNewTalk [coppied from extensions/wikia/WikiaNewtalk/shared_newtalks.sql]
CREATE TABLE IF NOT EXISTS `shared_newtalks` (
  `sn_user_id` int(5) unsigned default NULL,
  `sn_user_ip` varchar(255) default '',
  `sn_wiki` varchar(31) default NULL,
  `sn_date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  KEY `sn_user_id_sn_user_ip_sn_wiki_idx` (`sn_user_id`,`sn_user_ip`,`sn_wiki`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- ShareFeature extension --

CREATE TABLE IF NOT EXISTS `share_feature` (
  `sf_user_id` int(5) unsigned NOT NULL,
  `sf_provider_id` int(2) unsigned NOT NULL,
  `sf_clickcount` int(11) default '0',
  PRIMARY KEY (sf_user_id, sf_provider_id)
);

INSERT INTO `share_feature` VALUES (0, 0, 1000);
INSERT INTO `share_feature` VALUES (0, 1, 900);
INSERT INTO `share_feature` VALUES (0, 2, 800);
INSERT INTO `share_feature` VALUES (0, 3, 700);
INSERT INTO `share_feature` VALUES (0, 4, 600);
INSERT INTO `share_feature` VALUES (0, 5, 500);
INSERT INTO `share_feature` VALUES (0, 6, 400);
INSERT INTO `share_feature` VALUES (0, 7, 300);

-- garbage collector for WikiaMiniUpload temporary files --

CREATE TABLE IF NOT EXISTS `garbage_collector` (
  `gc_id` int(11) NOT NULL auto_increment,
  `gc_filename` varchar(285) character set latin1 collate latin1_bin NOT NULL default '',
  `gc_timestamp` varchar(14) character set latin1 collate latin1_bin NOT NULL default '',
  `gc_wiki_id` int(9) NOT NULL,
  PRIMARY KEY  (`gc_id`),
  KEY `gc_timestamp` (`gc_timestamp`)
);

-- language id 
-- run script maintenance/wikia/migrateLangNameToId.php to fill `city_lang` table

CREATE TABLE IF NOT EXISTS `city_lang` (
  `lang_id` mediumint(2) unsigned NOT NULL auto_increment,
  `lang_code` char(8) NOT NULL,
  `lang_name` varchar(255) NOT NULL,
  PRIMARY KEY  (`lang_id`),
  KEY `lang_code_idx` (`lang_code`)
) ENGINE=InnoDB;

