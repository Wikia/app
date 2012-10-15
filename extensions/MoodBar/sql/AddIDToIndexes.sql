-- Drop and recreate indexes to add mbf_id to the end
DROP INDEX /*i*/type_timestamp ON /*_*/moodbar_feedback;
DROP INDEX /*i*/title_type ON /*_*/moodbar_feedback;
CREATE INDEX /*i*/mbf_type_timestamp_id ON /*_*/moodbar_feedback (mbf_type,mbf_timestamp, mbf_id);
CREATE INDEX /*i*/mbf_title_type_id ON /*_*/moodbar_feedback (mbf_namespace,mbf_title,mbf_type,mbf_timestamp, mbf_id);