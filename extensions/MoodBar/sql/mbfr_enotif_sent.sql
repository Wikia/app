-- Adds mbfr_enotif_sent
ALTER TABLE /*_*/moodbar_feedback_response ADD COLUMN mbfr_enotif_sent tinyint unsigned not null default 0;
