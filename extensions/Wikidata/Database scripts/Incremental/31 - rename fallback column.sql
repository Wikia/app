ALTER TABLE wikidata_sets CHANGE set_string set_fallback_name VARCHAR(255);
INSERT INTO `script_log` (`time`, `script_name`, `comment`) VALUES (NOW(), '31 - rename fallback column.sql', 'rename wikidata_sets.set_string to set_fallback_name');
