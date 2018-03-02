DROP TABLE IF EXISTS `city_list`;
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
