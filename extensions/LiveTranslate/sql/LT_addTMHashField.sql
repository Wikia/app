-- Adds the memory_version_hash field to the live_translate_memories table. Change made in version 1.2.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

ALTER TABLE /*_*/live_translate_memories ADD COLUMN memory_version_hash VARCHAR(255) NOT NULL default '...';
