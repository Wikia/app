ALTER TABLE `uw_collection_contents` 
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);