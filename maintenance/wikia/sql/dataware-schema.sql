-- MySQL dump 10.13  Distrib 5.6.24-72.2, for debian-linux-gnu (x86_64)
--
-- Host: geo-db-archive-slave.query.consul    Database: dataware
-- ------------------------------------------------------
-- Server version	5.7.18-15-log


--
-- Table structure for table `ab_config`
--

DROP TABLE IF EXISTS `ab_config`;
CREATE TABLE `ab_config` (
  `id` int(11) NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiment_group_ranges`
--

DROP TABLE IF EXISTS `ab_experiment_group_ranges`;
CREATE TABLE `ab_experiment_group_ranges` (
  `group_id` int(11) NOT NULL,
  `version_id` int(11) NOT NULL,
  `ranges` varchar(255) DEFAULT NULL,
  `styles` blob,
  `scripts` blob,
  PRIMARY KEY (`version_id`,`group_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `fk_range_group` FOREIGN KEY (`group_id`) REFERENCES `ab_experiment_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_range_version` FOREIGN KEY (`version_id`) REFERENCES `ab_experiment_versions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiment_groups`
--

DROP TABLE IF EXISTS `ab_experiment_groups`;
CREATE TABLE `ab_experiment_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` tinyblob,
  `experiment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `experiment_id` (`experiment_id`),
  CONSTRAINT `fk_group_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `ab_experiments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiment_versions`
--

DROP TABLE IF EXISTS `ab_experiment_versions`;
CREATE TABLE `ab_experiment_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `experiment_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `ga_slot` varchar(45) NOT NULL,
  `control_group_id` int(11) DEFAULT NULL,
  `flags` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `experiment_id` (`experiment_id`),
  KEY `control_group_id` (`control_group_id`),
  CONSTRAINT `fk_version_control_group` FOREIGN KEY (`control_group_id`) REFERENCES `ab_experiment_groups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_version_experiment` FOREIGN KEY (`experiment_id`) REFERENCES `ab_experiments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `ab_experiments`
--

DROP TABLE IF EXISTS `ab_experiments`;
CREATE TABLE `ab_experiments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` tinyblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `blobs`
--

DROP TABLE IF EXISTS `blobs`;
CREATE TABLE `blobs` (
  `blob_id` int(10) NOT NULL AUTO_INCREMENT,
  `blob_text` mediumtext NOT NULL,
  PRIMARY KEY (`blob_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
(PARTITION p0 VALUES LESS THAN (10388840) ENGINE = InnoDB,
 PARTITION p1 VALUES LESS THAN (20777680) ENGINE = InnoDB,
 PARTITION p2 VALUES LESS THAN (41555360) ENGINE = InnoDB,
 PARTITION p3 VALUES LESS THAN (62333040) ENGINE = InnoDB,
 PARTITION p4 VALUES LESS THAN (83110720) ENGINE = InnoDB,
 PARTITION p5 VALUES LESS THAN (103888400) ENGINE = InnoDB,
 PARTITION p6 VALUES LESS THAN MAXVALUE ENGINE = InnoDB) */;
DELIMITER ;;
        DECLARE global_row_cnt INT DEFAULT -1;
        DECLARE wikia_row_cnt INT DEFAULT -1;

        DECLARE edits_ns INT DEFAULT -1;

        DECLARE global_first_rev INT DEFAULT 0;
        DECLARE wikia_first_rev INT DEFAULT 0;
        DECLARE global_page_first INT DEFAULT 0;
        DECLARE wikia_page_first INT DEFAULT 0;
        DECLARE global_ns_first INT DEFAULT 0;
        DECLARE wikia_ns_first INT DEFAULT 0;

        DECLARE wikia_ts_edit_first TIMESTAMP DEFAULT NULL;
        DECLARE global_ts_edit_first TIMESTAMP DEFAULT NULL;
        
        DECLARE page_status_value INT DEFAULT 1;

        
        SELECT  edit_count INTO edits_ns 
        FROM user_edits_summary WHERE city_id = NEW.rev_wikia_id and edit_ns = NEW.rev_namespace and user_id = NEW.rev_user;
        
        SELECT  edit_count, rev_first, page_first, ns_first, ts_edit_first 
        INTO wikia_row_cnt, wikia_first_rev, wikia_page_first, wikia_ns_first, wikia_ts_edit_first
        FROM user_summary WHERE user_id = NEW.rev_user and city_id = NEW.rev_wikia_id;
        
        SELECT  edit_count, rev_first, page_first, ns_first, ts_edit_first  
        INTO global_row_cnt, global_first_rev, global_page_first, global_ns_first, global_ts_edit_first 
        FROM user_summary WHERE user_id = NEW.rev_user and city_id = 0;
        
        SELECT  page_status INTO page_status_value FROM pages WHERE page_wikia_id = NEW.rev_wikia_id and page_id = NEW.rev_page_id;
        IF page_status_value = 0 THEN 
                
                IF wikia_row_cnt >= 0 THEN
                        
                        UPDATE  user_summary SET 
                        edit_count = wikia_row_cnt + 1, 
                        rev_last = NEW.rev_id,
                        page_last = NEW.rev_page_id,
                        ns_last = NEW.rev_namespace,
                        ts_edit_last = NEW.rev_timestamp,
                        rev_first = if(wikia_first_rev=0, NEW.rev_id, wikia_first_rev),
                        page_first = if(wikia_first_rev=0, NEW.rev_page_id, wikia_page_first),
                        ns_first = if(wikia_first_rev=0, NEW.rev_namespace, wikia_ns_first),
                        ts_edit_first = if(wikia_first_rev=0, NEW.rev_timestamp, wikia_ts_edit_first)
                        WHERE user_id = NEW.rev_user and city_id = NEW.rev_wikia_id;
                ELSE
                        INSERT INTO  user_summary (city_id, user_id, edit_count, rev_first, rev_last, page_first, page_last, ns_first, ns_last, ts_edit_first, ts_edit_last)
                        VALUES (NEW.rev_wikia_id, NEW.rev_user, 1, NEW.rev_id, NEW.rev_id, NEW.rev_page_id, NEW.rev_page_id, NEW.rev_namespace, NEW.rev_namespace, NEW.rev_timestamp, NEW.rev_timestamp);
                END IF;
                
                if edits_ns >= 0 THEN
                        UPDATE  user_edits_summary SET 
                        edit_count = edits_ns + 1 
                        WHERE user_id = NEW.rev_user and city_id = NEW.rev_wikia_id and edit_ns = NEW.rev_namespace;
                ELSE
                        INSERT INTO  user_edits_summary (city_id, user_id, edit_ns, edit_count)
                        VALUES (NEW.rev_wikia_id, NEW.rev_user, NEW.rev_namespace, 1);
                END IF;
                
                IF global_row_cnt >= 0 THEN
                        
                        UPDATE  user_summary SET 
                        edit_count = global_row_cnt + 1, 
                        rev_last = NEW.rev_id,
                        page_last = NEW.rev_page_id,
                        ns_last = NEW.rev_namespace,
                        ts_edit_last = NEW.rev_timestamp,
                        rev_first = if(global_first_rev=0, NEW.rev_id, global_first_rev),
                        page_first = if(global_first_rev=0, NEW.rev_page_id, global_page_first),
                        ns_first = if(global_first_rev=0, NEW.rev_namespace, global_ns_first),
                        ts_edit_first = if(global_first_rev=0, NEW.rev_timestamp, global_ts_edit_first)
                        WHERE user_id = NEW.rev_user and city_id = 0;
                ELSE
                        INSERT INTO  user_summary (city_id, user_id, edit_count, rev_first, rev_last, page_first, page_last, ns_first, ns_last, ts_edit_first, ts_edit_last)
                        VALUES (0, NEW.rev_user, 1, NEW.rev_id, NEW.rev_id, NEW.rev_page_id, NEW.rev_page_id, NEW.rev_namespace, NEW.rev_namespace, NEW.rev_timestamp, NEW.rev_timestamp);
                END IF;
        END IF;        
END */;;
DELIMITER ;

--
-- Table structure for table `chat_ban_users`
--

DROP TABLE IF EXISTS `chat_ban_users`;
CREATE TABLE `chat_ban_users` (
  `cbu_wiki_id` int(10) NOT NULL DEFAULT '0',
  `cbu_user_id` int(10) NOT NULL DEFAULT '0',
  `cbu_admin_user_id` int(10) NOT NULL DEFAULT '0',
  `reason` varbinary(255) DEFAULT NULL,
  `start_date` varbinary(14) DEFAULT NULL,
  `end_date` varbinary(14) DEFAULT NULL,
  UNIQUE KEY `cbu_user_id` (`cbu_wiki_id`,`cbu_user_id`),
  KEY `wiki_start_date` (`cbu_wiki_id`,`start_date`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;

--
-- Table structure for table `chat_blocked_users`
--

DROP TABLE IF EXISTS `chat_blocked_users`;
CREATE TABLE `chat_blocked_users` (
  `cbu_user_id` int(11) NOT NULL DEFAULT '0',
  `cbu_blocked_user_id` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `cbu_user_id` (`cbu_user_id`,`cbu_blocked_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `email_types`
--

DROP TABLE IF EXISTS `email_types`;
CREATE TABLE `email_types` (
  `id` tinyint(3) unsigned NOT NULL,
  `type` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `global_watchlist`
--

DROP TABLE IF EXISTS `global_watchlist`;
CREATE TABLE `global_watchlist` (
  `gwa_user_id` int(11) DEFAULT NULL,
  `gwa_city_id` int(11) DEFAULT NULL,
  `gwa_namespace` int(11) DEFAULT NULL,
  `gwa_title` varchar(255) DEFAULT NULL,
  `gwa_rev_id` int(11) DEFAULT NULL,
  `gwa_timestamp` varchar(14) DEFAULT NULL,
  `gwa_rev_timestamp` varchar(14) DEFAULT NULL,
  UNIQUE KEY `wikia_user` (`gwa_city_id`,`gwa_user_id`,`gwa_namespace`,`gwa_title`),
  KEY `user_id` (`gwa_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `page_wikia_id` int(8) unsigned NOT NULL,
  `page_id` int(8) unsigned NOT NULL,
  `page_namespace` int(8) unsigned NOT NULL DEFAULT '0',
  `page_title` varchar(255) NOT NULL,
  `page_is_content` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_is_redirect` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `page_latest` int(8) unsigned NOT NULL DEFAULT '0',
  `page_last_edited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `page_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`page_wikia_id`,`page_id`),
  KEY `page_title_namespace_latest_idx` (`page_title`,`page_namespace`,`page_latest`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `portability_dashboard`
--

DROP TABLE IF EXISTS `portability_dashboard`;
CREATE TABLE `portability_dashboard` (
  `wiki_id` int(11) NOT NULL,
  `portability` decimal(5,4) DEFAULT '0.0000',
  `infobox_portability` decimal(5,4) DEFAULT '0.0000',
  `traffic` int(11) DEFAULT '0',
  `migration_impact` int(11) DEFAULT '0',
  `typeless` int(11) DEFAULT '0',
  `custom_infoboxes` int(11) DEFAULT '0',
  `excluded` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user_flags`
--

DROP TABLE IF EXISTS `user_flags`;
CREATE TABLE `user_flags` (
  `city_id` int(9) NOT NULL,
  `user_id` int(10) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `data` varchar(255) NOT NULL,
  PRIMARY KEY (`city_id`,`user_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `wall_notification`
--

DROP TABLE IF EXISTS `wall_notification`;
CREATE TABLE `wall_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `author_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL,
  `entity_key` char(30) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `notifyeveryone` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unique_id` (`unique_id`),
  KEY `user_wiki_unique` (`user_id`,`wiki_id`,`unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wall_notification_queue`
--

DROP TABLE IF EXISTS `wall_notification_queue`;
CREATE TABLE `wall_notification_queue` (
  `wiki_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wiki_id`,`page_id`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wall_notification_queue_processed`
--

DROP TABLE IF EXISTS `wall_notification_queue_processed`;
CREATE TABLE `wall_notification_queue_processed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `entity_key` varbinary(30) NOT NULL,
  `event_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_event_idx` (`user_id`,`entity_key`),
  KEY `event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `wikiastaff_log`
--

DROP TABLE IF EXISTS `wikiastaff_log`;
CREATE TABLE `wikiastaff_log` (
  `slog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slog_type` varbinary(10) NOT NULL DEFAULT '',
  `slog_action` varbinary(10) NOT NULL DEFAULT '',
  `slog_timestamp` binary(14) NOT NULL DEFAULT '19700101000000',
  `slog_user` int(10) unsigned NOT NULL DEFAULT '0',
  `slog_userdst` int(10) unsigned NOT NULL DEFAULT '0',
  `slog_comment` blob,
  `slog_params` blob,
  `slog_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `slog_site` varbinary(200) DEFAULT NULL,
  `slog_user_name` varbinary(255) NOT NULL,
  `slog_user_namedst` varbinary(255) NOT NULL,
  `slog_city` int(11) DEFAULT NULL,
  PRIMARY KEY (`slog_id`),
  KEY `slog_time` (`slog_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Dump completed on 2018-02-28 15:33:32
