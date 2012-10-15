-- Tables for QuizGame extension
CREATE TABLE /*_*/quizgame_questions (
  `q_id` int(11) unsigned NOT NULL auto_increment PRIMARY KEY,
  `q_user_id` int(11) unsigned NOT NULL default '0',
  `q_user_name` varchar(255) NOT NULL default '',
  -- One of the QUIZGAME_FLAG_* constants
  -- 0 = QUIZGAME_FLAG_NONE = default state
  -- 1 = QUIZGAME_FLAG_FLAGGED = flagged
  -- 2 = QUIZGAME_FLAG_PROTECT = protected
  --`q_flag` enum('NONE','PROTECT','FLAGGED') NOT NULL default 'NONE',
  `q_flag` tinyint(2) NOT NULL default '0',
  `q_text` varchar(255) NOT NULL default '',
  `q_answer_count` int(11) default '0',
  `q_answer_correct_count` int(11) default '0',
  -- This was originally varchar(45), which sucked
  `q_picture` varchar(255) NOT NULL default '',
  `q_date` datetime default NULL,
  `q_random` double unsigned default '0',
  `q_comment` varchar(255) default ''
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/q_user_id ON /*_*/quizgame_questions (q_user_id);
CREATE INDEX /*i*/q_random ON /*_*/quizgame_questions (q_random);

CREATE TABLE /*_*/quizgame_answers (
  `a_id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY,
  `a_q_id` int(10) unsigned NOT NULL default '0',
  `a_choice_id` int(11) unsigned NOT NULL default '0',
  `a_user_id` int(11) unsigned NOT NULL default '0',
  `a_user_name` varchar(255) NOT NULL default '',
  `a_points` int(11) unsigned NOT NULL default '0',
  `a_date` datetime default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/a_q_id ON /*_*/quizgame_answers (a_q_id);
CREATE INDEX /*i*/a_choice_id ON /*_*/quizgame_answers (a_choice_id);
CREATE INDEX /*i*/a_user_id ON /*_*/quizgame_answers (a_user_id);
CREATE INDEX /*i*/a_user_name ON /*_*/quizgame_answers (a_user_name);

CREATE TABLE /*_*/quizgame_choice (
  `choice_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `choice_q_id` int(11) NOT NULL default '0',
  `choice_order` int(5) default '0',
  `choice_text` text NOT NULL,
  `choice_answer_count` int(11) NOT NULL,
  `choice_is_correct` tinyint(4) NOT NULL default '0'
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/choice_q_id ON /*_*/quizgame_choice (choice_q_id);

CREATE TABLE /*_*/quizgame_user_view (
  `uv_id` int(11) unsigned NOT NULL auto_increment PRIMARY KEY,
  `uv_q_id` int(11) unsigned NOT NULL default '0',
  `uv_user_id` int(11) unsigned NOT NULL default '0',
  `uv_user_name` varchar(255) NOT NULL default '',
  `uv_date` datetime default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/uv_user_id ON /*_*/quizgame_user_view (uv_user_id);
CREATE INDEX /*i*/uv_q_id ON /*_*/quizgame_user_view (uv_q_id);