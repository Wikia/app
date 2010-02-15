CREATE TABLE IF NOT EXISTS `kw_keywords` (
`kw_id` int(8) unsigned NOT NULL auto_increment,
`kw_word` varchar(255) NOT NULL,
`kw_count` int(8) unsigned NOT NULL default '1',
PRIMARY KEY  (`kw_id`),
UNIQUE KEY `kw_word` (`kw_word`),
UNIQUE KEY `kw_word_2` (`kw_word`),
KEY `kw_count` (`kw_count`)
);

CREATE TABLE IF NOT EXISTS `kw_page` (
`kw_key` int(8) unsigned NOT NULL,
`kw_page` int(8) unsigned NOT NULL,
`kw_ptype` int(1) NOT NULL default '0',
KEY `kw_key` (`kw_key`),
KEY `kw_page` (`kw_page`)
);
