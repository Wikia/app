--
--Add indices to language_id fields to speed up certain large queries
--

ALTER TABLE `uw_expression_ns`
	ADD INDEX (`language_id`);

ALTER TABLE `language_names`
	ADD INDEX (`language_id`);

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '24 - Add language ID indices.sql');
