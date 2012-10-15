-- The _ns suffix was initially intended to indicate namespace entry
-- points. This is neither particularly helpful nor consistently done.

RENAME TABLE /*$wdPrefix*/expression_ns to /*$wdPrefix*/expression;
RENAME TABLE /*$wdPrefix*/collection_ns to /*$wdPrefix*/collection;

-- Obsolete, never used. We may decide to add some of these again later, or 
-- implement differently - point is, right now it's just crud.

DROP TABLE /*$wdPrefix*/syntrans_relations;

ALTER TABLE /*$wdPrefix*/syntrans drop column firstuse;
ALTER TABLE /*$wdPrefix*/expression drop column hyphenation;
ALTER TABLE /*$wdPrefix*/translated_content drop column original_language_id;

-- The idea here was to use the same table for different kinds of multilingual
-- content. But we might just create a separate table for that in the future,
-- and merge *_text into *_translated_content.

ALTER TABLE /*$wdPrefix*/translated_content drop column shorttext_id;

-- Old MediaWiki crud,
DROP TABLE IF EXISTS validate;

INSERT INTO `script_log` (`time`, `script_name`, `comment`) VALUES (NOW(), '34 - Table cleanup.sql', "Name and column cleanup for /*$wdPrefix*/ dataset");
