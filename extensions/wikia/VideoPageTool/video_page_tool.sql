CREATE TABLE IF NOT EXISTS `vpt_program` (
  `program_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `publish_date` datetime NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`program_id`),
  UNIQUE KEY `program` (`language`, `publish_date`),
  KEY `publish_date` (`publish_date`, `language`, `is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `vpt_asset` (
  `asset_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `program_id` int(10) unsigned NOT NULL,
  `section` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
  `order` tinyint(4) NOT NULL DEFAULT '1',
  `data` blob NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`asset_id`),
  UNIQUE KEY `asset` (`program_id`, `section`, `order`),
  KEY `program_id` (`program_id`, `section`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
