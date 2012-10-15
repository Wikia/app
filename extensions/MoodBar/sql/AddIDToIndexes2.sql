-- Drop and recreate indexes to add mbf_id to the end
DROP INDEX /*i*/mbf_userid_ip_timestamp ON /*_*/moodbar_feedback;
DROP INDEX /*i*/mbf_type_userid_ip_timestamp ON /*_*/moodbar_feedback;
DROP INDEX /*i*/mbf_timestamp ON /*_*/moodbar_feedback;
-- Recreation is done in mbf_timestamp_id.sql
