CREATE TABLE recentchanges_detail (
 `wiki_id` int(8) unsigned NOT NULL,
 `wiki_cat_id` tinyint(2) unsigned NOT NULL DEFAULT '0',
 `user_id` int(8) unsigned NOT NULL,
 `rev_id` int(8) unsigned NOT NULL,
 `page_id` int(8) unsigned NOT NULL,
 `page_ns` smallint(5) unsigned NOT NULL,
 `detail_key` varchar(32),
 `detail_value` varchar(255),
 `timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' 
) Engine=InnoDB DEFAULT CHARSET=utf8;
