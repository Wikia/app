--
--Add class attributes table to store which attributes can be added to object's that belong to a class
--

CREATE TABLE `uw_class_attributes` (
	`object_id` INT NOT NULL ,
	`class_mid` INT NOT NULL DEFAULT '0',
	`attribute_mid` INT NOT NULL DEFAULT '0',
	`add_transaction_id` INT NOT NULL ,
	`remove_transaction_id` INT NULL
);

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '21 - Add class attributes.sql');