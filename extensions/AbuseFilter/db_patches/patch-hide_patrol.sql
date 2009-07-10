-- Add hiding and patrolling ability to abuse filter log
-- Andrew Garrett, June 2009

ALTER TABLE /*_*/abuse_filter_log ADD COLUMN afl_deleted tinyint(1) NULL;
ALTER TABLE /*_*/abuse_filter_log ADD COLUMN afl_patrolled_by int unsigned NULL;
