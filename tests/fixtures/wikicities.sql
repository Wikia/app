CREATE TABLE `city_list` (
  `city_id` int NOT NULL PRIMARY KEY AUTOINCREMENT,
  `city_path` varchar(255) NOT NULL DEFAULT '/home/wikicities/cities/notreal',
  `city_dbname` varchar(64) NOT NULL DEFAULT 'notreal',
  `city_sitename` varchar(255) NOT NULL DEFAULT 'wikicities',
  `city_url` varchar(255) NOT NULL DEFAULT 'http://notreal.wikicities.com/',
  `city_created` datetime DEFAULT NULL,
  `city_founding_user` int(5) DEFAULT NULL,
  `city_adult` tinyint(1) DEFAULT '0',
  `city_public` int(1) NOT NULL DEFAULT '1',
  `city_additional` text,
  `city_description` text,
  `city_title` varchar(255) DEFAULT NULL,
  `city_founding_email` varchar(255) DEFAULT NULL,
  `city_lang` varchar(8) NOT NULL DEFAULT 'en',
  `city_special_config` text,
  `city_umbrella` varchar(255) DEFAULT NULL,
  `city_ip` varchar(256) NOT NULL DEFAULT '/usr/wikia/source/wiki',
  `city_google_analytics` varchar(100) DEFAULT '',
  `city_google_search` varchar(100) DEFAULT '',
  `city_google_maps` varchar(100) DEFAULT '',
  `city_indexed_rev` int unsigned NOT NULL DEFAULT '1',
  `city_lastdump_timestamp` varchar(14) DEFAULT '19700101000000',
  `city_factory_timestamp` varchar(14) DEFAULT '19700101000000',
  `city_useshared` tinyint(1) DEFAULT '1',
  `ad_cat` char(4) NOT NULL DEFAULT '',
  `city_flags` int unsigned NOT NULL DEFAULT '0',
  `city_cluster` varchar(255) DEFAULT NULL,
  `city_last_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `city_vertical` int(11) NOT NULL DEFAULT '0',
  `city_founding_ip_bin` varbinary(16) DEFAULT NULL
);

CREATE UNIQUE INDEX `urlidx` ON `city_list` (`city_url`);
CREATE UNIQUE INDEX `city_dbname_idx` ON `city_list` (`city_dbname`);
CREATE INDEX `titleidx` ON `city_list` (`city_title`);
CREATE INDEX `city_flags` ON `city_list` (`city_flags`);
CREATE INDEX `city_created` ON `city_list` (`city_created`,`city_lang`);
CREATE INDEX `city_founding_user_inx` ON `city_list` (`city_founding_user`);
CREATE INDEX `city_cluster` ON `city_list`(`city_cluster`);
CREATE INDEX `city_founding_ip_bin` ON `city_list` (`city_founding_ip_bin`);

CREATE TABLE `city_domains` (
  `city_id` int(9) NOT NULL,
  `city_domain` varchar(255) NOT NULL DEFAULT 'wikia.com',
  PRIMARY KEY (`city_id`,`city_domain`)
);

CREATE UNIQUE INDEX `city_domains_archive_idx_uniq` ON `city_domains` (`city_domain`);

CREATE TABLE `city_variables` (
  `cv_city_id` int(9) NOT NULL,
  `cv_variable_id` smallint(5) NOT NULL DEFAULT '0',
  `cv_value` text NOT NULL,
  PRIMARY KEY (`cv_variable_id`,`cv_city_id`)
);

CREATE INDEX `cv_city_id_archive` ON `city_variables` (`cv_city_id`);
CREATE INDEX `cv_variable_id` ON `city_variables` (`cv_variable_id`,`cv_value`);

CREATE TABLE `city_variables_pool` (
  `cv_id` smallint(5) NOT NULL PRIMARY KEY AUTOINCREMENT,
  `cv_name` varchar(255) NOT NULL,
  `cv_description` text NOT NULL,
  `cv_variable_type` text NOT NULL DEFAULT 'integer',
  `cv_variable_group` tinyint(3) NOT NULL DEFAULT '1',
  `cv_access_level` tinyint(3) NOT NULL DEFAULT '1', -- '1 - read only\n2 - admin writable\n3 - user writable\n',
  `cv_is_unique` int(1) DEFAULT '0'
);

CREATE UNIQUE INDEX `idx_name_unique` ON `city_variables_pool` (`cv_name`);

CREATE TABLE `city_tag` (
  `id` int(8) NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name` varchar(255) DEFAULT NULL
);

CREATE UNIQUE INDEX `city_tag_name_uniq` ON `city_tag` (`name`);

CREATE TABLE `city_tag_map` (
  `city_id` int(9) NOT NULL,
  `tag_id` int(8) NOT NULL,
  PRIMARY KEY (`city_id`,`tag_id`)
);

CREATE INDEX `tag_id` ON `city_tag_map` (`tag_id`);
