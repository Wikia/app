--
--Script that cleans the datbase from tables and columns that are
--not used now en probably will not be used in the future.
--

DROP TABLE
	`shorttext`,
	`uw_versions_ns_collection`,
	`uw_versions_ns_gemet`;
	
ALTER TABLE `translated_content`
	DROP `data_id`;

ALTER TABLE	`uw_expression_ns`
	DROP `mediafile_id`,
	DROP `firstuse`;

ALTER TABLE `uw_syntrans`
	CHANGE `endemic_meaning` `identical_meaning` TINYINT( 1 ) NOT NULL DEFAULT '0';

ALTER TABLE `revision`
	DROP `rev_data_id`;

ALTER TABLE `page`
	DROP `page_title_language_id`,
	DROP `parent_title_page_id`;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '17 - Remove unused tables and columns.sql'); 