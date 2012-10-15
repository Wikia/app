-- Adds the memory_id field to the live_translate table, introduced in version 0.4.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

ALTER TABLE /*_*/live_translate ADD COLUMN memory_id INT(4) unsigned NOT NULL;
UPDATE /*_*/live_translate SET memory_id = 1;