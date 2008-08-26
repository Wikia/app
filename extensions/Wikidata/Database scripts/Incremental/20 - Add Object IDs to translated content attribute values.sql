START TRANSACTION;

INSERT INTO `objects` (`table`, `original_id`, UUID)
	(SELECT DISTINCT 'uw_translated_content_attribute_values', value_tcid, UUID() FROM uw_translated_content_attribute_values);
	
ALTER TABLE uw_translated_content_attribute_values
	ADD `value_id` INT NOT NULL DEFAULT '0' FIRST,
	ADD INDEX (`value_id`);	
	
UPDATE uw_translated_content_attribute_values, objects 
	SET uw_translated_content_attribute_values.value_id=objects.object_id 
	WHERE objects.table='uw_translated_content_attribute_values'
	AND objects.original_id=uw_translated_content_attribute_values.value_tcid;
	
INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '20 - Add Object IDs to translated content attribute values.sql');	
	
COMMIT;
