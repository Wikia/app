CREATE TABLE IF NOT EXISTS `player_stats_log` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `time_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `file_url` varchar(255) character set utf8 collate utf8_bin NOT NULL,
  `user_hash` char(40) character set utf8 collate utf8_bin NOT NULL,
  `html5_video_enabled` tinyint(1) default NULL,
  `java_enabled` tinyint(1) default NULL,
  `flash_enabled` tinyint(1) default NULL,
  `quicktime_enabled` tinyint(1) default NULL,
  `vlc_enabled` tinyint(1) default NULL,
  `mplayer_enabled` tinyint(1) default NULL,
  `totem_enabled` tinyint(1) default NULL,
  `b_user_agent` varchar(254) character set utf8 collate utf8_bin NOT NULL,
  `b_name` enum('Chrome','OmniWeb','Safari','Opera','iCab','Konqueror','Mozilla','Firefox','Camino','Netscape','Explorer') character set utf8 collate utf8_bin default NULL,
  `b_version` varchar(20) character set utf8 collate utf8_bin default NULL,
  `b_os` enum('Linux','Windows','Mac') character set utf8 collate utf8_bin default NULL,
  `flash_version` varchar(128) character set utf8 collate utf8_bin default NULL,
  `java_version` varchar(128) character set utf8 collate utf8_bin default NULL,
  PRIMARY KEY  (`id`),
  KEY `user_hash` (`user_hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `player_stats_survey` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_hash` char(40) collate utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `embed_key` enum('youtube','oggHandler','flowplayer') collate utf8_bin default NULL,
  `player_stats_log_id` int(11) unsigned default NULL,
  `ps_could_play` tinyint(1) default NULL,
  `ps_jumpy_playback` tinyint(1) NOT NULL,
  `ps_no_video` tinyint(1) NOT NULL,
  `ps_bad_sync` tinyint(1) NOT NULL,
  `ps_no_sound` tinyint(1) NOT NULL,
  `ps_would_install` tinyint(1) default NULL,
  `ps_would_switch` tinyint(1) default NULL,
  `ps_your_email` varchar(200) collate utf8_bin NOT NULL,
  `ps_problems_desc` text collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_hash` (`user_hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;