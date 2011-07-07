DROP TABLE IF EXISTS `path_segments_archive`;

CREATE TABLE `path_segments_archive` (
  `city_id` int(8) unsigned NOT NULL,
  `referrer_id` int(8) unsigned NOT NULL,
  `target_id` int(8) unsigned NOT NULL,
  `count` bigint(20) unsigned NOT NULL,
  `updated` date NOT NULL,
  PRIMARY KEY (`city_id`,`referrer_id`,`target_id`,`updated`),
  UNIQUE INDEX comp_key (`city_id`, `referrer_id`, `target_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;