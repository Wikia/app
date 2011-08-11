CREATE TABLE IF NOT EXISTS `searchdigest` (
	`sd_wiki` int(9) unsigned NOT NULL,
	`sd_query` varchar(255) NOT NULL,
	`sd_misses` int(9) unsigned NOT NULL,
	`sd_lastseen` DATE,
	PRIMARY KEY `sd_wikiquery` (`sd_wiki`, `sd_query`),
	KEY `sd_wikimisses` (`sd_wiki`, `sd_misses`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
