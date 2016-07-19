-- Schema for WikiFactory tables
--
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `city_cat_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id_idx` (`city_id`),
  KEY `cat_id_idx` (`cat_id`),
  CONSTRAINT `city_cat_mapping_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_cats` (
  `cat_id` int(9) NOT NULL auto_increment,
  `cat_name` varchar(255) default NULL,
  `cat_url` text,
  `cat_short` varchar(255) DEFAULT NULL,
  `cat_deprecated` boolean DEFAULT 0,
  `cat_active` boolean DEFAULT 0,
  PRIMARY KEY  (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_verticals` (
  `vertical_id` int(9) NOT NULL auto_increment,
  `vertical_name` varchar(255) default NULL,
  `vertical_url` text,
  `vertical_short` varchar(255) DEFAULT NULL,
  PRIMARY KEY  (`vertical_id`),
  KEY `vertical_name_idx` (`vertical_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_domains` (
  `city_id` int(9) NOT NULL,
  `city_domain` varchar(255) NOT NULL default 'wikia.com',
  PRIMARY KEY  (`city_id`,`city_domain`),
  UNIQUE KEY `city_domains_idx_uniq` (`city_domain`),
  CONSTRAINT `city_domains_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_list` (
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
  `city_lang` varchar(8) NOT NULL default 'en',
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
  `city_flags` int(10) unsigned NOT NULL default '0',
  `city_cluster` varchar(255) default NULL,
  `city_last_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `city_founding_ip` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`city_id`),
  KEY `city_dbname_idx` (`city_dbname`),
  KEY `titleidx` (`city_title`),
  KEY `urlidx` (`city_url`),
  KEY `city_flags` (`city_flags`),
  KEY `city_founding_ip` (`city_founding_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_list_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_city_id` int(9) NOT NULL,
  `cl_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cl_user_id` int(5) unsigned DEFAULT NULL,
  `cl_type` int(5) NOT NULL,
  `cl_text` mediumtext NOT NULL,
  `cl_var_id` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cl_city_id_idx` (`cl_city_id`),
  KEY `cl_type_idx` (`cl_type`),
  KEY `cl_timestamp_idx` (`cl_timestamp`),
  KEY `var_city` (`cl_var_id`,`cl_city_id`),
  CONSTRAINT `city_list_log_ibfk_1` FOREIGN KEY (`cl_city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `city_tag` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `city_tag_name_uniq` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_tag_map` (
  `city_id` int(9) NOT NULL,
  `tag_id` int(8) unsigned NOT NULL,
  PRIMARY KEY  (`city_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `city_tag_map_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `city_tag_map_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `city_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_variables` (
  `cv_city_id` int(9) NOT NULL,
  `cv_variable_id` smallint(5) unsigned NOT NULL default '0',
  `cv_value` text NOT NULL,
  PRIMARY KEY  (`cv_variable_id`,`cv_city_id`),
  KEY `cv_city_id` (`cv_city_id`),
  CONSTRAINT `city_variables_ibfk_1` FOREIGN KEY (`cv_variable_id`) REFERENCES `city_variables_pool` (`cv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `city_variables_ibfk_2` FOREIGN KEY (`cv_city_id`) REFERENCES `city_list` (`city_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_variables_groups` (
  `cv_group_id` int(11) NOT NULL auto_increment,
  `cv_group_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cv_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `city_variables_pool` (
  `cv_id` smallint(5) unsigned NOT NULL auto_increment,
  `cv_name` varchar(255) NOT NULL,
  `cv_description` text NOT NULL,
  `cv_variable_type` enum('integer','long','string','float','array','boolean','text','struct','hash') NOT NULL default 'integer',
  `cv_variable_group` tinyint(3) unsigned NOT NULL default '1',
  `cv_access_level` tinyint(3) unsigned NOT NULL default '1' COMMENT '1 - read only\n2 - admin writable\n3 - user writable\n',
  PRIMARY KEY  (`cv_id`),
  UNIQUE KEY `idx_name_unique` (`cv_name`),
  KEY `name_unique` (`cv_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;
