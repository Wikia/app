drop table achievements_badges;
CREATE TABLE IF NOT EXISTS `achievements_badges` (
  `user_id` int(5) unsigned NOT NULL,
  `badge_type` tinyint(3) unsigned NOT NULL,
  `badge_lap` tinyint(3) unsigned DEFAULT NULL,
  `badge_level` tinyint(3) unsigned DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notified` tinyint(1) NOT NULL DEFAULT '0',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

drop table achievements_counters;
CREATE TABLE IF NOT EXISTS `achievements_counters` (
  `user_id` int(5) unsigned NOT NULL,
  `data` text NOT NULL,
  `score` int(5) DEFAULT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;