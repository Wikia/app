-- Add some indexes to the moodbar_feedback table

CREATE INDEX /*i*/mbf_userid_ip_timestamp_id ON /*_*/moodbar_feedback (mbf_user_id, mbf_user_ip, mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_type_userid_ip_timestamp_id ON /*_*/moodbar_feedback (mbf_type, mbf_user_id, mbf_user_ip, mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_timestamp_id ON /*_*/moodbar_feedback (mbf_timestamp, mbf_id);
