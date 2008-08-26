CREATE TABLE `uw_class_membership` (
	`class_mid` INT NOT NULL default '0',
	`class_member_mid` INT NOT NULL default '0',
	`add_transaction_id` INT NOT NULL,
	`remove_transaction_id` INT default NULL,
	KEY `class_member_class` (`class_member_mid`, `class_mid`),
	KEY `class_class_member` (`class_mid`, `class_member_mid`),
	KEY `add_transaction_id` (`add_transaction_id`),
	KEY `remove_transaction_id` (`remove_transaction_id`)
);

INSERT INTO `uw_class_membership` (`class_mid`, `class_member_mid`, `add_transaction_id`, `remove_transaction_id`)
	(SELECT `meaning2_mid`, `meaning1_mid`, `add_transaction_id`, `remove_transaction_id` 
	 FROM `uw_meaning_relations`
	 WHERE `relationtype_mid` = 0);
	 
DELETE FROM `uw_meaning_relations`
	 WHERE `relationtype_mid` = 0;
	 
UPDATE uw_collection_ns
	SET collection_type='CLAS' 
	WHERE collection_type='ATTR'; 