START TRANSACTION;

--
-- Create object table
--

CREATE TABLE `objects` (
	`object_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`table` VARCHAR(100) NOT NULL,
	`original_id` INT NOT NULL
);

ALTER TABLE `objects`
	ADD INDEX (`table`),
	ADD INDEX (`original_id`);

------------------------------------------------------------------------
-- DEFINED MEANINGS
------------------------------------------------------------------------

--
-- Convert defined meaning ids to object ids
--

INSERT INTO `objects` (`table`, `original_id`)
	(SELECT DISTINCT 'uw_defined_meaning', defined_meaning_id FROM uw_defined_meaning);
	
UPDATE uw_defined_meaning, objects 
	SET uw_defined_meaning.defined_meaning_id=objects.object_id 
	WHERE uw_defined_meaning.defined_meaning_id=objects.original_id AND objects.table='uw_defined_meaning';
	
-- 
-- Update defined meaning ids in uw_alt_meaningtexts
--
	
ALTER TABLE uw_alt_meaningtexts
	ADD INDEX `tmp_index1` (`meaning_mid`),
	ADD INDEX `tmp_index2` (`source_id`);
	
UPDATE uw_alt_meaningtexts, objects 
	SET uw_alt_meaningtexts.meaning_mid=objects.object_id 
	WHERE uw_alt_meaningtexts.meaning_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
UPDATE uw_alt_meaningtexts, objects 
	SET uw_alt_meaningtexts.source_id=objects.object_id 
	WHERE uw_alt_meaningtexts.source_id=objects.original_id AND objects.table='uw_defined_meaning';
	
ALTER TABLE uw_alt_meaningtexts
	DROP INDEX `tmp_index1`,
	DROP INDEX `tmp_index2`;
	
-- 
-- Update defined meaning ids in uw_collection_contents
--
	
ALTER TABLE uw_collection_contents
	ADD INDEX `tmp_index1` (`member_mid`);
	
UPDATE uw_collection_contents, objects 
	SET uw_collection_contents.member_mid=objects.object_id 
	WHERE uw_collection_contents.member_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
ALTER TABLE uw_collection_contents
	DROP INDEX `tmp_index1`;

-- 
-- Update defined meaning ids in uw_collection_ns
--
	
ALTER TABLE uw_collection_ns
	ADD INDEX `tmp_index1` (`collection_mid`);
	
UPDATE uw_collection_ns, objects 
	SET uw_collection_ns.collection_mid=objects.object_id 
	WHERE uw_collection_ns.collection_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
ALTER TABLE uw_collection_ns
	DROP INDEX `tmp_index1`;
	
-- 
-- Update defined meaning ids in uw_dm_text_attribute_values
--
	
ALTER TABLE uw_dm_text_attribute_values
	ADD INDEX `tmp_index1` (`defined_meaning_id`),
	ADD INDEX `tmp_index2` (`attribute_mid`);
	
UPDATE uw_dm_text_attribute_values, objects 
	SET uw_dm_text_attribute_values.defined_meaning_id=objects.object_id 
	WHERE uw_dm_text_attribute_values.defined_meaning_id=objects.original_id AND objects.table='uw_defined_meaning';
	
UPDATE uw_dm_text_attribute_values, objects 
	SET uw_dm_text_attribute_values.attribute_mid=objects.object_id 
	WHERE uw_dm_text_attribute_values.attribute_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
ALTER TABLE uw_dm_text_attribute_values
	DROP INDEX `tmp_index1`,
	DROP INDEX `tmp_index2`;
	
-- 
-- Update defined meaning ids in uw_meaning_relations
--
	
ALTER TABLE uw_meaning_relations
	ADD INDEX `tmp_index1` (`meaning1_mid`),
	ADD INDEX `tmp_index2` (`meaning2_mid`),
	ADD INDEX `tmp_index3` (`relationtype_mid`);
	
UPDATE uw_meaning_relations, objects 
	SET uw_meaning_relations.meaning1_mid=objects.object_id 
	WHERE uw_meaning_relations.meaning1_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
UPDATE uw_meaning_relations, objects 
	SET uw_meaning_relations.meaning2_mid=objects.object_id 
	WHERE uw_meaning_relations.meaning2_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
UPDATE uw_meaning_relations, objects 
	SET uw_meaning_relations.relationtype_mid=objects.object_id 
	WHERE uw_meaning_relations.relationtype_mid=objects.original_id AND objects.table='uw_defined_meaning';
	
ALTER TABLE uw_meaning_relations
	DROP INDEX `tmp_index1`,
	DROP INDEX `tmp_index2`,
	DROP INDEX `tmp_index3`;
	
-- 
-- Update defined meaning ids in uw_syntrans
--
	
ALTER TABLE uw_syntrans
	ADD INDEX `tmp_index1` (`defined_meaning_id`);
	
UPDATE uw_syntrans, objects 
	SET uw_syntrans.defined_meaning_id=objects.object_id 
	WHERE uw_syntrans.defined_meaning_id=objects.original_id AND objects.table='uw_defined_meaning';
	
ALTER TABLE uw_syntrans
	DROP INDEX `tmp_index1`;

------------------------------------------------------------------------
-- EXPRESSSIONS
------------------------------------------------------------------------

--
-- Convert expression ids to object ids
--

INSERT INTO `objects` (`table`, `original_id`)
	(SELECT DISTINCT 'uw_expression_ns', expression_id FROM uw_expression_ns);
	
UPDATE uw_expression_ns, objects 
	SET uw_expression_ns.expression_id=objects.object_id 
	WHERE uw_expression_ns.expression_id=objects.original_id AND objects.table='uw_expression_ns';

-- 
-- Update expression ids in uw_defined_meaning
--
	
ALTER TABLE uw_defined_meaning
	ADD INDEX `tmp_index1` (`expression_id`);
	
UPDATE uw_defined_meaning, objects 
	SET uw_defined_meaning.expression_id=objects.object_id 
	WHERE uw_defined_meaning.expression_id=objects.original_id AND objects.table='uw_expression_ns';
	
ALTER TABLE uw_defined_meaning
	DROP INDEX `tmp_index1`;

-- 
-- Update expression ids in uw_syntrans
--
	
ALTER TABLE uw_syntrans
	ADD INDEX `tmp_index1` (`expression_id`);
	
UPDATE uw_syntrans, objects 
	SET uw_syntrans.expression_id=objects.object_id 
	WHERE uw_syntrans.expression_id=objects.original_id AND objects.table='uw_expression_ns';
	
ALTER TABLE uw_syntrans
	DROP INDEX `tmp_index1`;

------------------------------------------------------------------------
-- COLLECTIONS
------------------------------------------------------------------------

--
-- Convert collection ids to object ids
--

INSERT INTO `objects` (`table`, `original_id`)
	(SELECT DISTINCT 'uw_collection_ns', collection_id FROM uw_collection_ns);
	
UPDATE uw_collection_ns, objects 
	SET uw_collection_ns.collection_id=objects.object_id 
	WHERE uw_collection_ns.collection_id=objects.original_id AND objects.table='uw_collection_ns';

-- 
-- Update collection ids in uw_collection_contents
--
	
ALTER TABLE uw_collection_contents
	ADD INDEX `tmp_index1` (`collection_id`);
	
UPDATE uw_collection_contents, objects 
	SET uw_collection_contents.collection_id=objects.object_id 
	WHERE uw_collection_contents.collection_id=objects.original_id AND objects.table='uw_collection_ns';
	
ALTER TABLE uw_collection_contents
	DROP INDEX `tmp_index1`;

------------------------------------------------------------------------
-- TRANSLATED CONTENT
------------------------------------------------------------------------

--
-- Convert translated content ids to object ids
--

INSERT INTO `objects` (`table`, `original_id`)
	(SELECT DISTINCT 'translated_content', set_id FROM translated_content);
	
UPDATE translated_content, objects 
	SET translated_content.set_id=objects.object_id 
	WHERE translated_content.set_id=objects.original_id AND objects.table='translated_content';

-- 
-- Update translated content ids in uw_alt_meaningtexts
--
	
ALTER TABLE uw_alt_meaningtexts
	ADD INDEX `tmp_index1` (`meaning_text_tcid`);
	
UPDATE uw_alt_meaningtexts, objects 
	SET uw_alt_meaningtexts.meaning_text_tcid=objects.object_id 
	WHERE uw_alt_meaningtexts.meaning_text_tcid=objects.original_id AND objects.table='translated_content';
	
ALTER TABLE uw_alt_meaningtexts
	DROP INDEX `tmp_index1`;

-- 
-- Update translated content ids in uw_defined_meaning
--
	
ALTER TABLE uw_defined_meaning
	ADD INDEX `tmp_index1` (`meaning_text_tcid`);
	
UPDATE uw_defined_meaning, objects 
	SET uw_defined_meaning.meaning_text_tcid=objects.object_id 
	WHERE uw_defined_meaning.meaning_text_tcid=objects.original_id AND objects.table='translated_content';
	
ALTER TABLE uw_defined_meaning
	DROP INDEX `tmp_index1`;

-- 
-- Update translated content ids in uw_dm_text_attribute_values
--
	
ALTER TABLE uw_dm_text_attribute_values
	ADD INDEX `tmp_index1` (`value_tcid`);
	
UPDATE uw_dm_text_attribute_values, objects 
	SET uw_dm_text_attribute_values.value_tcid=objects.object_id 
	WHERE uw_dm_text_attribute_values.value_tcid=objects.original_id AND objects.table='translated_content';
	
ALTER TABLE uw_dm_text_attribute_values
	DROP INDEX `tmp_index1`;

--
-- Change set_id to translated_content_id in translated content
--

ALTER TABLE `translated_content` 
	CHANGE `set_id` `translated_content_id` INT NOT NULL DEFAULT '0';

COMMIT;