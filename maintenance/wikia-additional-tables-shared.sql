-- This file should only contain Wikia-specific tables,
-- which are meant to be created in _shared_ databases.

-- Initial data should also be put here.

-- Note that this file is subject to move to /wikia subdirectory.

create table if not exists locks (
    lock_id int not null auto_increment primary key,
    facility varchar(255) not null,
    host varchar(255) not null,
    process_id int not null,
    created timestamp default now(),
    reason varchar(255) not null
) ENGINE=InnoDB;

create table if not exists widgets (
    wt_id int not null auto_increment primary key,
    wt_class varchar(32) not null,
    wt_instance varchar(32) not null,
    wt_level int not null,
    wt_wikia varchar(200),
    wt_user bigint
) ENGINE=InnoDB;

create table if not exists widgets_extra (
    we_id int not null auto_increment primary key,
    we_widget_id int not null,
    we_name varchar(32) not null,
    we_value mediumtext not null,
    we_blocked int not null
) ENGINE=InnoDB;

create table if not exists jabstatus (
  id int not null auto_increment primary key,
  wikia varchar(200) not null,
  user int not null default 0,
  jid varchar(50) not null,
  status varchar(10) not null,
  presence char(1) not null default 'A'
) ENGINE=InnoDB;

create table if not exists send_queue (
    que_id int not null auto_increment primary key,
    que_tm timestamp default now(),
    que_ip varchar(16) not null,
    que_to mediumtext not null,
    que_from varchar(255) not null,
    que_name varchar(255) not null,
    que_user varchar(255) not null,
    que_subject varchar(255) not null,
    que_body mediumtext not null,
    que_sent int not null default 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `city_list` (
  `city_id` int(9) NOT NULL auto_increment,
  `city_path` varchar(255) NOT NULL default '/home/wikicities/cities/notreal',
  `city_dbname` varchar(64) NOT NULL default 'notreal',
  `city_sitename` varchar(255) NOT NULL default 'wikicities',
  `city_url` varchar(255) NOT NULL default 'http://notreal.wikicities.com/',
  `city_created` datetime default NULL,
  `city_founding_user` int(5) default NULL,
  `city_adult` tinyint(1) default '0',
  `city_public` int(1) NOT NULL default '1',
  `city_additional` text,
  `city_description` text,
  `city_title` varchar(255) default NULL,
  `city_founding_email` varchar(255) default NULL,
  `city_lang` varchar(7) NOT NULL default 'en',
  `city_special_config` text,
  `city_umbrella` varchar(255) default NULL,
  `city_ip` varchar(256) NOT NULL default '/usr/wikia/source/wiki',
  `city_google_analytics` varchar(100) default '',
  `city_google_search` varchar(100) default '',
  `city_google_maps` varchar(100) default '',
  `city_indexed_rev` int(8) unsigned NOT NULL default '1',
  `city_lastdump_timestamp` varchar(14) default '19700101000000',
  `city_factory_timestamp` varchar(14) default '19700101000000',
  `city_useshared` tinyint(1) default '1',
  `ad_cat` char(4) NOT NULL default '',
  `city_flags` int(10) unsigned NOT NULL default '0',
  `city_cluster` varchar(255) default NULL,
  `city_last_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`city_id`),
  KEY `city_dbname_idx` (`city_dbname`),
  KEY `titleidx` (`city_title`),
  KEY `urlidx` (`city_url`),
  KEY `city_flags` (`city_flags`)
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS `city_list_requests` (
  `request_id` int(11) NOT NULL auto_increment,
  `request_name` varchar(255) NOT NULL,
  `request_user_id` int(9) unsigned default NULL,
  `request_language` varchar(10) NOT NULL default '',
  `request_category` varchar(255) NOT NULL default '',
  `request_title` tinytext,
  `request_community` tinytext,
  `request_description_page` tinytext,
  `request_description_english` tinytext,
  `request_description_international` tinytext,
  `request_timestamp` char(14) NOT NULL,
  `request_comments` tinytext,
  `request_questions` tinytext,
  `request_status` tinyint(3) unsigned NOT NULL default '0',
  `request_moreinfo` tinytext,
  `request_extrainfo` tinytext,
  PRIMARY KEY  (`request_id`),
  UNIQUE KEY `request_name` (`request_name`),
  KEY `idx_city_list_requests_name_lang` (`request_name`,`request_language`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `city_domains` (
  `city_id` int(10) unsigned NOT NULL,
  `city_domain` varchar(255) NOT NULL default 'wikia.com',
  PRIMARY KEY  (`city_id`,`city_domain`),
  UNIQUE KEY `city_domains_idx_uniq` (`city_domain`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `city_cat_mapping` (
  `city_id` int(11) default NULL,
  `cat_id` int(11) default NULL,
  KEY `city_id_idx` (`city_id`),
  KEY `cat_id_idx` (`cat_id`),
  CONSTRAINT `city_cat_mapping_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB ;

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

# default widgets scheme for all wikias

insert into widgets values ( 1, 'WidgetTopContent', '1', 0, null, null );
insert into widgets_extra values ( null, 1, 'column', '2', 0 );
insert into widgets_extra values ( null, 1, 'position', '1', 0 );

insert into widgets values ( 2, 'WidgetSidebar', '1', 0, null, null );
insert into widgets_extra values ( null, 2, 'column', '2', 0 );
insert into widgets_extra values ( null, 2, 'position', '2', 0 );

insert into widgets values ( 3, 'WidgetWikiaToolbox', '1', 0, null, null );
insert into widgets_extra values ( null, 3, 'column', '2', 0 );
insert into widgets_extra values ( null, 3, 'position', '3', 0 );



insert into widgets values ( 4, 'WidgetWikiaMessages', '1', 0, null, null );
insert into widgets_extra values ( null, 4, 'column', '2', 0 );
insert into widgets_extra values ( null, 4, 'position', '4', 0 );

insert into widgets values ( 5, 'WidgetSearch', '1', 0, null, null );
insert into widgets_extra values ( null, 5, 'column', '2', 0 );
insert into widgets_extra values ( null, 5, 'position', '5', 0 );

insert into widgets values ( 6, 'WidgetExpertTools', '1', 0, null, null );
insert into widgets_extra values ( null, 6, 'column', '2', 0 );
insert into widgets_extra values ( null, 6, 'position', '6', 0 );

insert into widgets values ( 7, 'WidgetThisArticle', '1', 0, null, null );
insert into widgets_extra values ( null, 7, 'column', '2', 0 );
insert into widgets_extra values ( null, 7, 'position', '7', 0 );

insert into widgets values ( 8, 'WidgetLanguageUrls', '1', 0, null, null );
insert into widgets_extra values ( null, 8, 'column', '2', 0 );
insert into widgets_extra values ( null, 8, 'position', '8', 0 );



insert into widgets values ( 9, 'WidgetThisWiki', '1', 0, null, null );
insert into widgets_extra values ( null, 9, 'column', '1', 0 );
insert into widgets_extra values ( null, 9, 'position', '1', 0 );

insert into widgets values ( 10, 'WidgetTopFive', '1', 0, null, null );
insert into widgets_extra values ( null, 10, 'column', '1', 0 );
insert into widgets_extra values ( null, 10, 'position', '2', 0 );

-- site-wide messages
CREATE TABLE IF NOT EXISTS system_events (
  `ev_id` int(7) unsigned not null auto_increment,
  `ev_name` varchar(255) not null,
  `ev_user_id` int(9) unsigned NOT NULL default '0',
  `ev_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ev_desc` text not null,
  `ev_hook` varchar(255) not null,
  `ev_hook_values` mediumtext not null,
  `ev_active` tinyint(3) NOT NULL default 0,
  PRIMARY KEY (`ev_id`)
) ENGINE=InnoDB;

insert into system_events values (null, 'welcome visitor', '115748', now(), 'Welcome message - when user visit page for first time', 'BeforePageDisplay', '', 0);
insert into system_events values (null, 'CreateVisitorPage', '115748', now(), 'Show message before create user page (for visitors)', 'EditPage::attemptSave', '', 0);
insert into system_events values (null, 'VotePage', '115748', now(), 'Show message when user hasn\'t vote any page', 'BeforePageDisplay', '', 0);
insert into system_events values (null, 'EditPageByVisitor', '115748', now(), 'Show message where user hasn\'t edit any page (for visitors)', 'GetUserMessages', '', 0);
insert into system_events values (null, 'WatchPage', '115748', now(), 'Get notified when some page is updated (for visitors)', 'EditPage::attemptSave', '', 0);
insert into system_events values (null, 'DiscussArticle', '115748', now(), 'Check out the forum and join the discussion (for visitors)', 'EditPage::attemptSave', '', 0);
insert into system_events values (null, 'welcome user', '115748', now(), 'Show message after registration', 'AddNewAccount', '', 0);
insert into system_events values (null, 'CreateUserPage', '115748', now(), 'Show message where user has not own user page', 'GetUserMessages', '', 0);
insert into system_events values (null, 'EditPageByUser', '115748', now(), 'Show message when user didn\'t edit active page', 'GetUserMessages', '', 0);
insert into system_events values (null, 'SendToFriend', '115748', now(), 'Show message after edit user page', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'DiscussUserArticle', '115748', now(), 'Check out the forum and join the discussion (for registered users)', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'CreateArticle', '115748', now(), 'Show message to create some article (for reg. users and after edit page)', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'WatchUserPage', '115748', now(), 'Show message after edit page to know when page is updated (for reg. user)', 'ArticleSaveComplete', '', 0);
insert into system_events values (null, 'TagImage', '115748', now(), 'Show message to know how to tag image', 'BefWelcomeVisitorConditionorePageDisplay', '', 0);
insert into system_events values (null, 'FlickrPromo', '115748', now(), 'Show message when image page is displaying (reg. users)', 'BeforePageDisplay', '', 0);

CREATE TABLE IF NOT EXISTS system_events_types (
  `et_id` int(7) unsigned not null auto_increment,
  `et_name` varchar(255) not null,
  `et_user_id` int(9) unsigned NOT NULL default '0',
  `et_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `et_desc` text not null,
  `et_active` tinyint(3) NOT NULL default 1,
  PRIMARY KEY (`et_id`)
) ENGINE=InnoDB;

insert into system_events_types values (1, 'MessageBox', '115748', now(), 'Show text of event on the site', 1);
insert into system_events_types values (2, 'Email', '115748', now(), 'Send text of event by email', 1);

CREATE TABLE IF NOT EXISTS system_events_text (
  `te_id` int(7) unsigned not null auto_increment,
  `te_ev_id` int(7) unsigned not null,
  `te_user_id` int(9) unsigned NOT NULL default '0',
  `te_et_id` tinyint(3) NOT NULL default 0,
  `te_title` mediumtext NOT NULL,
  `te_content` text NOT NULL,
  `te_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`te_id`),
  KEY (`te_ev_id`, `te_et_id`)
) ENGINE=InnoDB;

insert into system_events_text values (null, 1, 115748, '1', '', 'welcome_event_content', now());
insert into system_events_text values (null, 2, 115748, '1', '', 'create_user_page_visitor_msg', now());
insert into system_events_text values (null, 3, 115748, '1', '', 'user_can_vote_page_msg', now());
insert into system_events_text values (null, 4, 115748, '1', '', 'user_can_edit_page_evt', now());
insert into system_events_text values (null, 5, 115748, '1', '', 'watch_page_visitor_msg', now());
insert into system_events_text values (null, 6, 115748, '1', '', 'discuss_article_visitor_msg', now());
insert into system_events_text values (null, 7, 115748, '1', '', 'welcome_user_msg', now());
insert into system_events_text values (null, 8, 115748, '1', '', 'create_user_page_msg', now());
insert into system_events_text values (null, 9, 115748, '1', '', 'edit_page_msg', now());
insert into system_events_text values (null, 10, 115748, '1', '', 'sent_to_friend_msg', now());
insert into system_events_text values (null, 11, 115748, '1', '', 'discuss_article_user_msg', now());
insert into system_events_text values (null, 12, 115748, '1', '', 'create_article_msg', now());
insert into system_events_text values (null, 13, 115748, '1', '', 'watch_page_user_msg', now());
insert into system_events_text values (null, 14, 115748, '1', '', 'tag_image_msg', now());
insert into system_events_text values (null, 15, 115748, '1', '', 'flickr_promo_msg', now());

CREATE TABLE IF NOT EXISTS system_events_data (
  `ed_id` int(7) unsigned not null auto_increment,
  `ed_city_id` int(7) unsigned not null,
  `ed_ev_id` int(7) unsigned not null default 0,
  `ed_et_id` int(7) unsigned not null default 0,
  `ed_user_id` int(9) unsigned NOT NULL default '0',
  `ed_user_ip` varchar(20) NOT NULL default '',
  `ed_field_id` varchar(255) default '',
  `ed_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`ed_id`),
  KEY (`ed_city_id`),
  KEY (`ed_ev_id`, `ed_et_id`),
  KEY (`ed_user_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS system_events_params (
  `ep_id` int(7) unsigned not null auto_increment,
  `ep_name` varchar(100) NOT NULL default '',
  `ep_value` varchar(100) NOT NULL default '',
  `ep_desc` text,
  `ep_user_id` int(9) unsigned NOT NULL default '0',
  `ep_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `ep_active` tinyint(3) NOT NULL default 1,
  PRIMARY KEY (`ep_id`),
  KEY (`ep_user_id`)
) ENGINE=InnoDB;

create index system_events_params_active on system_events_params(ep_active);

insert into system_events_params values (null, 'DisplayLength', '5', 'How much user\'s message should be visible on page', 0, now(), 1);
insert into system_events_params values (null, 'EmailsCount', '1', 'Number of emails that should be sent to user', 0, now(), 1);
insert into system_events_params values (null, 'TitleBold', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'TitleItalic', '1', '', 0, now(), 1);
insert into system_events_params values (null, 'TitleUnderline', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'ContentBold', '1', '', 0, now(), 1);
insert into system_events_params values (null, 'ContentItalic', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'ContentUnderline', '0', '', 0, now(), 1);
insert into system_events_params values (null, 'BackgroundColor', '#3366CC', '', 0, now(), 1);
insert into system_events_params values (null, 'LinkColor', '#FEC423', '', 0, now(), 1);
insert into system_events_params values (null, 'TextColor', '#FFFFFF', '', 0, now(), 1);

CREATE TABLE IF NOT EXISTS system_events_users (
  `eu_id` int(7) unsigned not null auto_increment,
  `eu_city_id` int(7) unsigned not null,
  `eu_ev_id` int(7) unsigned not null default 0,
  `eu_et_id` int(7) unsigned not null default 0,
  `eu_user_id` int(9) unsigned NOT NULL default '0',
  `eu_user_ip` varchar(20) NOT NULL default '',
  `eu_visible_count` int(5) default 0,
  `eu_active` int(5) default 1,
  `eu_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`eu_id`),
  KEY (`eu_city_id`),
  KEY (`eu_ev_id`, `eu_et_id`),
  KEY (`eu_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `city_list_log` (
  `cl_city_id` int(9) NOT NULL,
  `cl_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `cl_user_id` int(5) unsigned default NULL,
  `cl_type` int(5) NOT NULL,
  `cl_text` mediumtext NOT NULL,
  KEY `cl_city_id_idx` (`cl_city_id`),
  KEY `cl_type_idx` (`cl_type`),
  CONSTRAINT `city_list_log_ibfk_1` FOREIGN KEY (`cl_city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- user wikicities aint got enough rights to do views! ops need to be asked to run this query
--CREATE OR REPLACE VIEW city_cats_view AS SELECT city_id AS cc_city_id, cat_name AS cc_name FROM city_cats, city_cat_mapping WHERE city_cats.cat_id = city_cat_mapping.cat_id;

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

DROP TABLE IF EXISTS `city_cats`;
CREATE TABLE `city_cats` (
  `cat_id` int(9) NOT NULL auto_increment,
  `cat_name` varchar(255) default NULL,
  `cat_url` text,
  PRIMARY KEY  (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `city_variables_pool` (
  `cv_id` smallint(5) unsigned NOT NULL auto_increment,
  `cv_name` varchar(255) NOT NULL,
  `cv_description` text NOT NULL,
  `cv_variable_type` enum('integer','long','string','float','array','boolean','text','struct','hash') NOT NULL default 'integer',
  `cv_variable_group` tinyint(3) unsigned NOT NULL default '1',
  `cv_access_level` tinyint(3) unsigned NOT NULL default '1' COMMENT '1 - read only\n2 - admin writable\n3 - user writable\n',
  PRIMARY KEY  (`cv_id`),
  UNIQUE KEY `idx_name_unique` (`cv_name`),
  KEY `name_unique` (`cv_name`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `city_variables` (
  `cv_city_id` int(9) NOT NULL,
  `cv_variable_id` smallint(5) unsigned NOT NULL default '0',
  `cv_value` mediumblob NOT NULL,
  PRIMARY KEY  (`cv_variable_id`,`cv_city_id`),
  KEY `cv_city_id` (`cv_city_id`),
  CONSTRAINT `city_variables_ibfk_2` FOREIGN KEY (`cv_city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `city_variables_ibfk_1` FOREIGN KEY (`cv_variable_id`) REFERENCES `city_variables_pool` (`cv_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `city_cats` WRITE;
INSERT INTO `city_cats` VALUES (1,'Humor','http://www.wikia.com/wiki/Humor'),(2,'Gaming','http://gaming.wikia.com/'),(3,'Entertainment','http://entertainment.wikia.com/'),(4,'Wikia','http://www.wikia.com/wiki/Category:Hubs'),(5,'Toys','http://www.wikia.com/wiki/Toys'),(7,'Travel','http://www.wikia.com/wiki/Travel'),(8,'Education','http://www.wikia.com/wiki/Education'),(9,'Lifestyle','http://www.wikia.com/wiki/Lifestyle'),(10,'Finance','http://www.wikia.com/wiki/Finance'),(11,'Politics','http://www.wikia.com/wiki/Politics'),(12,'Technology','http://www.wikia.com/wiki/Technology'),(13,'Science','http://www.wikia.com/wiki/Science'),(14,'Philosophy','http://www.wikia.com/wiki/Philosophy'),(15,'Sports','http://www.wikia.com/wiki/Sports'),(16,'Music','http://www.wikia.com/wiki/Music'),(17,'Creative','http://www.wikia.com/wiki/Creative'),(18,'Auto','http://www.wikia.com/wiki/Auto'),(19,'Green','http://www.wikia.com/wiki/Green');
UNLOCK TABLES;

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

