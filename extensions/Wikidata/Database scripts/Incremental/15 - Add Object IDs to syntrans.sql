START TRANSACTION;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '15 - Add Object IDs to syntrans.sql');
	
CREATE TABLE `temporary_syntrans` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`defined_meaning_id` INT NOT NULL,
	`expression_id` INT NOT NULL,
	KEY `meaning_expression` (`defined_meaning_id`, `expression_id`)
);

INSERT INTO `temporary_syntrans` (defined_meaning_id, expression_id) (
	SELECT DISTINCT defined_meaning_id, expression_id
	FROM uw_syntrans
);
	
INSERT INTO `objects` (`table`, `original_id`, UUID)
	(SELECT DISTINCT 'uw_syntrans', id, UUID() FROM temporary_syntrans);
	
ALTER TABLE uw_syntrans
	CHANGE `syntrans_sid` `syntrans_sid` INT(10) NOT NULL DEFAULT '0',
	ADD INDEX (`syntrans_sid`);	
	
UPDATE uw_syntrans, temporary_syntrans, objects 
	SET uw_syntrans.syntrans_sid=objects.object_id 
	WHERE temporary_syntrans.id=objects.original_id AND objects.table='uw_syntrans'
	AND uw_syntrans.defined_meaning_id=temporary_syntrans.defined_meaning_id
	AND uw_syntrans.expression_id=temporary_syntrans.expression_id;
	
DROP TABLE `temporary_syntrans`;
	
COMMIT;
