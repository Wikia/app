-- Patch to add support for global filters

ALTER TABLE /*_*/abuse_filter ADD COLUMN af_global tinyint(1) NOT NULL DEFAULT 0;

ALTER TABLE /*_*/abuse_filter_log ADD COLUMN afl_wiki varchar(64) binary NULL;
ALTER TABLE /*_*/abuse_filter_log CHANGE COLUMN afl_filter afl_filter varchar(64) binary NOT NULL;
