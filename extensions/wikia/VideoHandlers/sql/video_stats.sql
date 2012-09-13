CREATE TABLE `video_stats` (
  `video_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `views_30days` int(10) unsigned DEFAULT '0',
  `views_total` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`video_title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
