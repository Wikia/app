START TRANSACTION;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '13 - Add Object IDs to relations.sql');
	
CREATE TABLE `temporary_relations` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`meaning1_mid` INT NOT NULL,
	`relationtype_mid` INT NOT NULL,
	`meaning2_mid` INT NOT NULL,
	KEY `meaning1_type_meaning2` (`meaning1_mid`, `relationtype_mid`, `meaning2_mid`)
);

INSERT INTO `temporary_relations` (meaning1_mid, relationtype_mid, meaning2_mid) (
	SELECT DISTINCT meaning1_mid, relationtype_mid, meaning2_mid
	FROM uw_meaning_relations
);
	
INSERT INTO `objects` (`table`, `original_id`, UUID)
	(SELECT DISTINCT 'uw_meaning_relations', id, UUID() FROM temporary_relations);
	
ALTER TABLE uw_meaning_relations
	ADD `relation_id` INT NOT NULL FIRST,
	ADD INDEX (`relation_id`);	
	
UPDATE uw_meaning_relations, temporary_relations, objects 
	SET uw_meaning_relations.relation_id=objects.object_id 
	WHERE temporary_relations.id=objects.original_id AND objects.table='uw_meaning_relations'
	AND uw_meaning_relations.meaning1_mid=temporary_relations.meaning1_mid
	AND uw_meaning_relations.meaning2_mid=temporary_relations.meaning2_mid
	AND uw_meaning_relations.relationtype_mid=temporary_relations.relationtype_mid;
	
DROP TABLE `temporary_relations`;
	
COMMIT;
