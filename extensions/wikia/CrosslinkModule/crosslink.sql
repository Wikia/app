CREATE TABLE IF NOT EXISTS `crosslink` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `source_wiki` int(8) unsigned NOT NULL,
  `source_page` int(8) unsigned NOT NULL,
  `target_wiki` int(8) unsigned NOT NULL,
  `target_page` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source` (`source_wiki`,`source_page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
