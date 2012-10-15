ALTER TABLE `uw_alt_meaningtexts` 
	CHANGE `source_id` `source_id` INT NOT NULL DEFAULT '0';
	
INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '16 - Update source_id column in uw_alt_meaningtexts.sql'); 