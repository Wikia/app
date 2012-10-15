ALTER TABLE `uw_defined_meaning` 
	DROP PRIMARY KEY,
	CHANGE `defined_meaning_id` `defined_meaning_id` INT(8) UNSIGNED NOT NULL,
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`defined_meaning_id`),
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);
	
ALTER TABLE `uw_alt_meaningtexts` 
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);
	
ALTER TABLE `uw_dm_text_attribute_values` 
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);
	
ALTER TABLE `uw_expression_ns` 
	DROP PRIMARY KEY,
	CHANGE `expression_id` `expression_id` INT UNSIGNED NOT NULL,
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`expression_id`),
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);
	
ALTER TABLE `uw_collection_ns` 
	DROP PRIMARY KEY,
	CHANGE `collection_id` `collection_id` INT UNSIGNED NOT NULL,
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`collection_id`),
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);