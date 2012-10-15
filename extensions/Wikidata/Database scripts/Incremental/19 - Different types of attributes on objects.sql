--
--Text attributes can be of any object, instead of only defined meanings
--

RENAME TABLE `uw_text_attribute_values` TO `uw_translated_content_attribute_values`;

--
--Add more types of attributes
--
CREATE TABLE `uw_text_attribute_values` (
	`value_id` INT NOT NULL ,
	`object_id` INT NOT NULL ,
	`attribute_mid` INT NOT NULL ,
	`text` VARCHAR( 255 ) NOT NULL  ,
	`add_transaction_id` INT NOT NULL ,
	`remove_transaction_id` INT NULL
);

CREATE TABLE `uw_url_attribute_values` (
	`value_id` INT NOT NULL ,
	`object_id` INT NOT NULL ,
	`attribute_mid` INT NOT NULL ,
	`url` VARCHAR( 255 ) NOT NULL  ,	
	`label`  VARCHAR( 255 ) NOT NULL  ,
	`add_transaction_id` INT NOT NULL ,
	`remove_transaction_id` INT NULL
);

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '19 - Different types of attributes on objects.sql'); 