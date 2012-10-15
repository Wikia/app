ALTER TABLE /*_*/abuse_filter_log MODIFY afl_deleted tinyint(1) NOT NULL DEFAULT 0;
ALTER TABLE /*_*/abuse_filter_log MODIFY afl_patrolled_by int unsigned NOT NULL DEFAULT 0;

