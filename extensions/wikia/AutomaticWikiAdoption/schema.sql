CREATE TABLE IF NOT EXISTS `user_flags` (
-- city_id
  `city_id` int(9) NOT NULL,
-- user_id
  `user_id` int(10) NOT NULL,
-- type - which extension this record is for
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
-- timestamp
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`city_id`,`user_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;