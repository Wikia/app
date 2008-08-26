--
-- Table structure for table `user_profile`
--

CREATE TABLE /*$wgDBprefix*/user_profile (
  `up_user_id` int(5) NOT NULL default '0',
  `up_location_city` varchar(255) default NULL,
  `up_location_state` varchar(100) default NULL,
  `up_location_country` varchar(255) default NULL,
  `up_hometown_city` varchar(255) default NULL,
  `up_hometown_state` varchar(100) default NULL,
  `up_hometown_country` varchar(255) default NULL,
  `up_birthday` date default NULL,
  `up_relationship` int(5) NOT NULL default '0',
  `up_occupation` varchar(255) default '',
  `up_companies` text,
  `up_about` text,
  `up_places_lived` text,
  `up_schools` text,
  `up_websites` text,
  `up_movies` text,
  `up_books` text,
  `up_magazines` text,
  `up_music` text,
  `up_tv` text,
  `up_drinks` text,
  `up_snacks` text,
  `up_video_games` text,
  `up_interests` text,
  `up_quotes` text,
  `up_custom_1` text,
  `up_custom_2` text,
  `up_custom_3` text,
  `up_custom_4` text,
  `up_custom_5` text,
  `up_last_seen` datetime default NULL,
  `up_type` int(5) NOT NULL default '1',
  PRIMARY KEY  (`up_user_id`)
) DEFAULT CHARSET=utf8;
