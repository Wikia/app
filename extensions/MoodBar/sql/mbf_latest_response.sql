ALTER TABLE /*_*/moodbar_feedback ADD COLUMN mbf_latest_response int unsigned NOT NULL default 0;
CREATE INDEX /*i*/mbf_latest_response ON /*_*/moodbar_feedback (mbf_latest_response);
