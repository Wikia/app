CREATE TABLE IF NOT EXISTS `video_info` (
  `video_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `provider` varchar(255) DEFAULT NULL,
  `added_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `added_by` int(10) unsigned NOT NULL DEFAULT '0',
  `duration` int(10) unsigned NOT NULL DEFAULT '0',
  `premium` tinyint(1) NOT NULL DEFAULT '0',
  `hdfile` tinyint(1) NOT NULL DEFAULT '0',
  `removed` tinyint(1) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `views_7day` int(10) unsigned DEFAULT '0',
  `views_30day` int(10) unsigned DEFAULT '0',
  `views_total` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`video_title`),
  KEY `added_at` (`added_at`, `duration`),
  KEY `premium` (`premium`, `added_at`),
  KEY `hdfile` (`hdfile`, `added_at`),
  KEY `featured` (`featured`, `added_at`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
