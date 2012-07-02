-- MySQL version of the database schema for the Contest extension.
-- Licence: GNU GPL v3+
-- Author: Jeroen De Dauw < jeroendedauw@gmail.com >

-- Contests
CREATE TABLE IF NOT EXISTS /*_*/contests (
  contest_id                   SMALLINT unsigned   NOT NULL auto_increment PRIMARY KEY,
  contest_name                 VARCHAR(255)        NOT NULL, -- String indentifier for the contest
  contest_status               TINYINT unsigned    NOT NULL default '0', -- Status of the contest. One of 0 (DRAFT), 1 (ACTIVE), 2 (FINISHED)
  contest_end                  varbinary(14)       NOT NULL default '', -- End time of the contest (MW timestamp)

  contest_rules_page           VARCHAR(255)        NOT NULL, -- Name of the page with rules
  contest_opportunities        VARCHAR(255)        NOT NULL, -- Name of the page with opportunities
  contest_intro                VARCHAR(255)        NOT NULL, -- Name of the page with the intro text
  contest_help                 VARCHAR(255)        NOT NULL, -- Name of the page with contest help
  contest_signup_email         VARCHAR(255)        NOT NULL, -- Name of the page with the signup email text
  contest_reminder_email       VARCHAR(255)        NOT NULL, -- Name of the page with the reminder email text

  contest_submission_count     SMALLINT unsigned   NOT NULL  -- Number of submissions made to the contest
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/contests_name ON /*_*/contests (contest_name);
CREATE INDEX /*i*/contests_status_end ON /*_*/contests (contest_status, contest_end);

-- Contestants
CREATE TABLE IF NOT EXISTS /*_*/contest_contestants (
  contestant_id                INT unsigned        NOT NULL auto_increment PRIMARY KEY, -- Contestant id (unique id per user per contest)
  contestant_contest_id        SMALLINT unsigned   NOT NULL, -- Foreign key on contests.contest_id
  contestant_user_id           INT(10) unsigned    NOT NULL, -- Foreign key on user.user_id
  contestant_challenge_id      INT unsigned        NOT NULL, -- Foreign key on contest_challenges.challenge_id

  -- These fields will be copied from the user table on contest lock
  contestant_full_name         VARCHAR(255)        NOT NULL, -- Full name of the contestant
  contestant_user_name         VARCHAR(255)        NOT NULL, -- User name of the contestant
  contestant_email             TINYBLOB            NOT NULL, -- Email of the contestant

  -- Extra contestant info
  contestant_country           VARCHAR(255)        NOT NULL, -- Country code of the contestant
  contestant_volunteer         TINYINT unsigned    NOT NULL, -- If the user is interested in volunteer opportunities
  contestant_wmf               TINYINT unsigned    NOT NULL, -- If the user is interested in a WMF job
  contestant_cv                TINYBLOB            NOT NULL, -- URL to the users CV

  contestant_submission        TINYBLOB            NOT NULL, -- URL to the users submission

  contestant_rating            SMALLINT unsigned   NOT NULL, -- The average rating of the contestant, multiplied by 100 for precision
  contestant_rating_count      SMALLINT unsigned   NOT NULL, -- The number of ratings
  contestant_comments          SMALLINT unsigned   NOT NULL  -- The number of comments
) /*$wgDBTableOptions*/;
-- TODO: probably need to split indexes, see queries in ContestantPager
CREATE INDEX /*i*/contest_contestants_contest_id ON /*_*/contest_contestants (contestant_contest_id, contestant_id);
CREATE INDEX /*i*/contest_contestants_challenge_id ON /*_*/contest_contestants (contestant_challenge_id, contestant_id);
CREATE INDEX /*i*/contest_contestants_contest_challenge ON /*_*/contest_contestants (contestant_contest_id, contestant_challenge_id);
CREATE INDEX /*i*/contest_contestants_contest_volunteer ON /*_*/contest_contestants (contestant_contest_id, contestant_volunteer);
CREATE INDEX /*i*/contest_contestants_challenge_volunteer ON /*_*/contest_contestants (contestant_challenge_id, contestant_volunteer);
CREATE INDEX /*i*/contest_contestants_contest_wmf ON /*_*/contest_contestants (contestant_contest_id, contestant_wmf);
CREATE INDEX /*i*/contest_contestants_challenge_wmf ON /*_*/contest_contestants (contestant_challenge_id, contestant_wmf);
CREATE INDEX /*i*/contest_contestants_contest_comments ON /*_*/contest_contestants (contestant_contest_id, contestant_comments);
CREATE INDEX /*i*/contest_contestants_challenge_comments ON /*_*/contest_contestants (contestant_challenge_id, contestant_comments);
CREATE INDEX /*i*/contest_contestants_contest_rating ON /*_*/contest_contestants (contestant_contest_id, contestant_rating);
CREATE INDEX /*i*/contest_contestants_challenge_rating ON /*_*/contest_contestants (contestant_challenge_id, contestant_rating);
CREATE INDEX /*i*/contest_contestants_contest_rating_count ON /*_*/contest_contestants (contestant_contest_id, contestant_rating_count);
CREATE INDEX /*i*/contest_contestants_challenge_rating_count ON /*_*/contest_contestants (contestant_challenge_id, contestant_rating_count);
CREATE UNIQUE INDEX /*i*/contest_contestants_id_user ON /*_*/contest_contestants (contestant_contest_id, contestant_user_id);

-- Challenges
CREATE TABLE IF NOT EXISTS /*_*/contest_challenges (
  challenge_id                INT unsigned        NOT NULL auto_increment PRIMARY KEY, -- Challenge id
  challenge_contest_id        INT unsigned        NOT NULL, -- Foreign key on contests.contest_id

  challenge_text              TEXT                NOT NULL, -- Full challenge description
  challenge_title             VARCHAR(255)        NOT NULL, -- Title of the challenge
  challenge_oneline           TEXT                NOT NULL -- One line description of the challenge
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/contest_challenges_contest_id ON /*_*/contest_challenges (challenge_contest_id);
CREATE UNIQUE INDEX /*i*/contest_challenges_title ON /*_*/contest_challenges (challenge_title);

-- Judge votes
CREATE TABLE IF NOT EXISTS /*_*/contest_votes (
  vote_id                      INT unsigned        NOT NULL auto_increment PRIMARY KEY,
  vote_contestant_id           INT unsigned        NOT NULL, -- Foreign key on contest_contestants.contestant_id
  vote_user_id                 INT(10) unsigned    NOT NULL, -- Judge user id

  vote_value                   SMALLINT            NOT NULL -- The value of the vote
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/contest_votes_contestant_user ON /*_*/contest_votes (vote_contestant_id, vote_user_id);
CREATE INDEX /*i*/contest_votes_user ON /*_*/contest_votes (vote_user_id);

-- Judge comments
CREATE TABLE IF NOT EXISTS /*_*/contest_comments (
  comment_id                   INT unsigned        NOT NULL auto_increment PRIMARY KEY,
  comment_contestant_id        INT unsigned        NOT NULL, -- Foreign key on contest_contestants.contestant_id
  comment_user_id              INT(10) unsigned    NOT NULL, -- Judge user id

  comment_text                 TEXT                NOT NULL, -- The comment text
  comment_time                 varbinary(14)       NOT NULL default '' -- The time at which the comment was made
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/contest_comments_id_time ON /*_*/contest_comments (comment_contestant_id, comment_time);
