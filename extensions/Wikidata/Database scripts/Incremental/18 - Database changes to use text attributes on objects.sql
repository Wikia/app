--
--Text attributes can be of any object, instead of only defined meanings
--

ALTER TABLE `uw_dm_text_attribute_values`
	CHANGE `defined_meaning_id` `object_id` INT( 11 ) NOT NULL;
	
RENAME TABLE `uw_dm_text_attribute_values` TO `uw_text_attribute_values`;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '18 - Database changes to use text attributes on objects.sql'); 