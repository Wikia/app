-- MySQL version of the database schema for the Survey extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

-- Surveys
CREATE TABLE IF NOT EXISTS /*_*/surveys (
  survey_id                SMALLINT unsigned   NOT NULL auto_increment PRIMARY KEY,
  survey_name              VARCHAR(255)        NOT NULL, -- String indentifier for the survey
  survey_title             VARCHAR(255)        NOT NULL, -- Title of the survey
  survey_enabled           TINYINT             NOT NULL default '0', -- If the survey can be taken by users
  survey_header            TEXT                NOT NULL, -- Text to display above the survey
  survey_footer            TEXT                NOT NULL, -- Text to display below the survey
  survey_thanks            TEXT                NOT NULL, -- Text to display after survey submission
  survey_user_type         TINYINT unsigned    NOT NULL default '0', -- Type of users that can participate in the survey
  survey_namespaces        BLOB                NOT NULL, -- Namespaces on which the survey can be displayed
  survey_ratio             TINYINT unsigned    NOT NULL, -- Percentage of users to show the survey to
  survey_expiry            INT unsigned        NOT NULL, -- Coockie expiry time for the survey
  survey_min_pages         TINYINT unsigned    NOT NULL -- Min amount of pages the user needs to view before getting the survey
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/surveys_survey_name ON /*_*/surveys (survey_name);
CREATE INDEX /*i*/surveys_survey_title ON /*_*/surveys (survey_title);
CREATE INDEX /*i*/surveys_survey_enabled ON /*_*/surveys (survey_enabled);
CREATE INDEX /*i*/surveys_survey_user_type ON /*_*/surveys (survey_user_type);
CREATE INDEX /*i*/surveys_survey_ratio ON /*_*/surveys (survey_ratio);
CREATE INDEX /*i*/surveys_survey_expiry ON /*_*/surveys (survey_expiry);
CREATE INDEX /*i*/surveys_survey_min_pages ON /*_*/surveys (survey_min_pages);

-- Questions
CREATE TABLE IF NOT EXISTS /*_*/survey_questions (
  question_id              INT(10) unsigned    NOT NULL auto_increment PRIMARY KEY,
  question_survey_id       SMALLINT unsigned   NOT NULL, -- Foreign key: surveys.survey_id
  question_text            TEXT                NOT NULL,
  question_type            INT(2) unsigned     NOT NULL,
  question_required        TINYINT             NOT NULL,
  question_answers         BLOB                NOT NULL,
  question_removed         TINYINT             NOT NULL default '0'
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/survey_questions_survey_id ON /*_*/survey_questions (question_survey_id);
CREATE INDEX /*i*/survey_questions_type ON /*_*/survey_questions (question_type);
CREATE INDEX /*i*/survey_questions_required ON /*_*/survey_questions (question_required);
CREATE INDEX /*i*/survey_questions_removed ON /*_*/survey_questions (question_removed);

-- Submissions
CREATE TABLE IF NOT EXISTS /*_*/survey_submissions (
  submission_id            INT(10) unsigned    NOT NULL auto_increment PRIMARY KEY,
  submission_survey_id     SMALLINT unsigned   NOT NULL, -- Foreign key: surveys.survey_id
  submission_user_name     VARCHAR(255)        NOT NULL, -- The person that made the submission (account name or ip)
  submission_page_id       INT(10) unsigned    NULL, -- The id of the page the submission was made on 
  submission_time          CHAR(14) binary     NOT NULL default '' -- The time the submission was made  
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/survey_submissions_survey_id ON /*_*/survey_submissions (submission_survey_id);
CREATE INDEX /*i*/survey_submissions_user_name ON /*_*/survey_submissions (submission_user_name);
CREATE INDEX /*i*/survey_submissions_page_id ON /*_*/survey_submissions (submission_page_id);
CREATE INDEX /*i*/survey_submissions_time ON /*_*/survey_submissions (submission_time);

-- Answers
CREATE TABLE IF NOT EXISTS /*_*/survey_answers (
  answer_id                SMALLINT unsigned   NOT NULL auto_increment PRIMARY KEY,
  answer_submission_id     INT(10) unsigned    NOT NULL, -- Foreign key: survey_submissions.submission_id
  answer_question_id       INT(10) unsigned    NOT NULL, -- Foreign key: survey_questions.question_id
  answer_text              BLOB                NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/surveys_submission_id ON /*_*/survey_answers (answer_submission_id);
CREATE INDEX /*i*/surveys_question_id ON /*_*/survey_answers (answer_question_id);
