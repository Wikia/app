ALTER TABLE /*_*/abuse_filter ADD COLUMN af_deleted tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE /*_*/abuse_filter_history ADD COLUMN afh_deleted tinyint(1) NOT NULL DEFAULT 0;
