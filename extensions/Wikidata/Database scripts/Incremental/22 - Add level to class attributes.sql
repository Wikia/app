--
--Add level_mid to class attributes table to store at which level (definition, relation, sytrans, ..) 
--attributes can be added
--

ALTER TABLE `uw_class_attributes`
	ADD `level_mid` INT NOT NULL AFTER `class_mid`;

INSERT INTO `script_log` (`time`, `script_name`)
	VALUES (NOW(), '22 - Add level to class attributes.sql');