-- SQL schema for the RegexBlock extension
-- these tables should go into your $wgSharedDB

CREATE TABLE IF NOT EXISTS `blockedby` (
  `blckby_id` int(5) NOT NULL auto_increment,
  `blckby_name` varchar(255) character set latin1 collate latin1_general_cs NOT NULL,
  `blckby_blocker` varchar(255) character set latin1 collate latin1_general_cs NOT NULL,
  `blckby_timestamp` char(14) NOT NULL,
  `blckby_expire` char(14) NOT NULL,
  `blckby_create` tinyint(1) NOT NULL default '1',
  `blckby_exact` tinyint(1) NOT NULL default '0',
  `blckby_reason` tinyblob NOT NULL,
  PRIMARY KEY  (`blckby_id`),
  UNIQUE KEY `blckby_name` (`blckby_name`),
  KEY `blckby_timestamp` (`blckby_timestamp`),
  KEY `blckby_expire` (`blckby_expire`),
  KEY `blockeridx` (`blckby_blocker`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `blockedby_stats` (
  `stats_id` int(8) NOT NULL auto_increment,
  `stats_blckby_id` int(8) NOT NULL,
  `stats_user` varchar(255) NOT NULL,
  `stats_blocker` varchar(255) NOT NULL,
  `stats_timestamp` char(14) NOT NULL,
  `stats_ip` char(15) NOT NULL,
  `stats_match` varchar(255) NOT NULL default '',
  `stats_dbname` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`stats_id`),
  KEY `stats_blckby_id_key` (`stats_blckby_id`),
  KEY `stats_timestamp` (`stats_timestamp`)
) ENGINE=InnoDB;
