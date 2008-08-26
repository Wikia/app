UPDATE user_groups SET ug_group='wikidata-omega' where ug_group='wikidata';
INSERT INTO `script_log` (`time`, `script_name`, `comment`) VALUES (NOW(), '32 - rename user group.sql', 'standardize group names for multiple data sets');
