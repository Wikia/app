-- Adds the mbf_hidden_state field to the moodbar_feedback table, for
-- hiding feedback from public view.
-- Andrew Garrett, 2011-10-07
ALTER TABLE /*_*/moodbar_feedback ADD COLUMN mbf_hidden_state tinyint unsigned not null default 0;
