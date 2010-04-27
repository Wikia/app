

-- time stamp for watch list
ALTER TABLE /*$wgDBprefix*/watchlist
	ADD `wl_wikia_addedtimestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE /*$wgDBprefix*/watchlist
	ADD INDEX wl_wikia_addedtimestamp ( wl_wikia_addedtimestamp );
