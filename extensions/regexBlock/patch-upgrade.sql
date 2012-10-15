ALTER TABLE stats_blockedby ADD COLUMN `stats_blckby_id` int(8) NOT NULL;
ALTER TABLE stats_blockedby ADD COLUMN `stats_match` varchar(255) NOT NULL default '';
ALTER TABLE stats_blockedby ADD COLUMN `stats_dbname` varchar(255) NOT NULL default '';
ALTER TABLE stats_blockedby ADD KEY `stats_blckby_id_key` (`stats_blckby_id`);