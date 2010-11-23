CREATE TABLE IF NOT EXISTS `groupstats` (
	`gs_group` varchar( 255 ),
	`gs_lang` varchar( 10 ),
	`gs_total` int( 9 ),
	`gs_translated` int( 9 ),
	`gs_fuzzy` int( 9 ),
	PRIMARY KEY ( `gs_group`, `gs_language` )	
);
