--
-- This script can be used to added versioning ability to wikidata tables.
--

--
-- Create transaction table which will store information about individual transactions.
-- Transaction ids will be used in other tables to tie 'add' and 'remove' operations 
-- on tables to a specific transaction.
--

CREATE TABLE `transactions` (
	`transaction_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` INT(5) NOT NULL,
	`user_ip` VARCHAR(15) NOT NULL,
	`timestamp` VARCHAR(14) NOT NULL,
	`comment` TINYBLOB NOT NULL
);

--
-- Add 'add_transaction_id' and 'remove_transaction_id' to versioned tables
--

ALTER TABLE `translated_content` 
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,

	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);
	
ALTER TABLE `uw_syntrans` 
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);

ALTER TABLE `uw_meaning_relations` 
	ADD `add_transaction_id` INT NOT NULL,
	ADD `remove_transaction_id` INT NULL,
	
	ADD INDEX (`add_transaction_id`), 
	ADD INDEX (`remove_transaction_id`);