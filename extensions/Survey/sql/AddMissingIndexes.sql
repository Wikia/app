-- SQL for the Survey extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

CREATE INDEX /*i*/surveys_survey_title ON /*_*/surveys (survey_title);
CREATE INDEX /*i*/surveys_survey_enabled ON /*_*/surveys (survey_enabled);
CREATE INDEX /*i*/surveys_survey_user_type ON /*_*/surveys (survey_user_type);
CREATE INDEX /*i*/surveys_survey_ratio ON /*_*/surveys (survey_ratio);
CREATE INDEX /*i*/surveys_survey_expiry ON /*_*/surveys (survey_expiry);
CREATE INDEX /*i*/surveys_survey_min_pages ON /*_*/surveys (survey_min_pages);

CREATE INDEX /*i*/survey_questions_survey_id ON /*_*/survey_questions (question_survey_id);
CREATE INDEX /*i*/survey_questions_type ON /*_*/survey_questions (question_type);
CREATE INDEX /*i*/survey_questions_required ON /*_*/survey_questions (question_required);
CREATE INDEX /*i*/survey_questions_removed ON /*_*/survey_questions (question_removed);

CREATE INDEX /*i*/survey_submissions_survey_id ON /*_*/survey_submissions (submission_survey_id);
CREATE INDEX /*i*/survey_submissions_user_name ON /*_*/survey_submissions (submission_user_name);
CREATE INDEX /*i*/survey_submissions_page_id ON /*_*/survey_submissions (submission_page_id);
CREATE INDEX /*i*/survey_submissions_time ON /*_*/survey_submissions (submission_time);
