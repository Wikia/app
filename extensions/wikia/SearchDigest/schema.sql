CREATE TABLE IF NOT EXISTS `searchdigest` (
	`sd_wiki` int(9) unsigned NOT NULL,
	`sd_query` varchar(255) unsigned NOT NULL,
	`sd_misses` varchar(9) unsigned NOT NULL,
	PRIMARY KEY `sd_wiki`	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
