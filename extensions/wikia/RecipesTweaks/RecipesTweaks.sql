ALTER TABLE `watchlist` ADD `wl_wikia_addedtimestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `watchlist` ADD INDEX ( `wl_wikia_addedtimestamp` );
