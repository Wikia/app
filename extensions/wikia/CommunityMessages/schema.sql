CREATE TABLE IF NOT EXISTS `user_messages` (
-- city_id
  `city_id` int(9) NOT NULL,
-- user_id
  `user_id` int(10) NOT NULL,
-- timestamp
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`city_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
