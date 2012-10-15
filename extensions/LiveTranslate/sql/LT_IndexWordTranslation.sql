-- Adds word translation index on the live_translate table.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

CREATE INDEX word_translation ON /*$wgDBprefix*/live_translate (word_id, word_language);
