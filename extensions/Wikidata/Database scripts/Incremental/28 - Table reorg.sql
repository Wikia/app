-- These tables can exist within each dataset.
CREATE TABLE `uw_script_log` as SELECT * from `script_log` limit 0;
RENAME TABLE objects to uw_objects;
RENAME TABLE bootstrapped_defined_meanings to uw_bootstrapped_defined_meanings;
RENAME TABLE translated_content to uw_translated_content;
RENAME TABLE transactions to uw_transactions;

-- Drop table so that the next create doesn't crash
DROP TABLE `uw_text`;

-- We used to share this with MediaWiki, but it makes more sense to
-- have our own within each data set.
CREATE TABLE `uw_text` (
  `text_id` int(8) unsigned NOT NULL auto_increment,
  `text_text` mediumblob NOT NULL,
  `text_flags` tinyblob NOT NULL,
  PRIMARY KEY  (`text_id`)
) DEFAULT CHARSET=utf8;
INSERT INTO `script_log` (`time`, `script_name`, `comment`) VALUES (NOW(), '28 - Table reorg.sql', 'reorganize tables for authoritative view');