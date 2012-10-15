/**
 * WARNING: Importing this file will drop existing data in QPoll tables,
 * if there's any!
 * Do not use directly in case your wiki DB setup uses table prefixes.
 * Use Special:QPollWebInstall page instead.
 * This file is primarily for debugging.
 */

DROP TABLE IF EXISTS `qp_poll_desc`;
CREATE TABLE `qp_poll_desc` (
  `pid` int unsigned NOT NULL auto_increment,
  `article_id` int unsigned NOT NULL,
  `poll_id` tinytext NOT NULL,
  `order_id` int unsigned NOT NULL,
  `dependance` text NOT NULL,
  interpretation_namespace int NOT NULL,
  interpretation_title varchar(255) binary NOT NULL,
  random_question_count int NOT NULL default 0,
  PRIMARY KEY poll (pid),
  UNIQUE INDEX article_poll (article_id,poll_id(128))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_question_desc`;
CREATE TABLE `qp_question_desc` (
  `pid` int unsigned NOT NULL,
  `question_id` int unsigned NOT NULL,
  `type` tinytext NOT NULL,
  `common_question` text NOT NULL,
  `name` tinytext default NULL,
  PRIMARY KEY question (pid,question_id),
  INDEX poll (pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* spans are going there, too - separated with | */
DROP TABLE IF EXISTS `qp_question_categories`;
CREATE TABLE `qp_question_categories` (
  `pid` int unsigned NOT NULL,
  `question_id` int unsigned NOT NULL,
  `cat_id` int unsigned NOT NULL,
  `cat_name` tinytext NOT NULL,
  PRIMARY KEY category (pid,question_id,cat_id),
  INDEX poll (pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_question_proposals`;
CREATE TABLE `qp_question_proposals` (
  `pid` int unsigned NOT NULL,
  `question_id` int unsigned NOT NULL,
  `proposal_id` int unsigned NOT NULL,
  `proposal_text` text NOT NULL,
  PRIMARY KEY proposal (pid,question_id,proposal_id),
  INDEX poll (pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_question_answers`;
CREATE TABLE `qp_question_answers` (
  `uid` int unsigned NOT NULL,
  `pid` int unsigned NOT NULL,
  `question_id` int unsigned NOT NULL,
  `proposal_id` int unsigned NOT NULL,
  `cat_id` int unsigned NOT NULL,
  `text_answer` text,
  PRIMARY KEY answer (uid,pid,question_id,proposal_id,cat_id),
  INDEX user_vote (uid,pid),
  INDEX poll_question (pid,question_id),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_users_polls`;
CREATE TABLE `qp_users_polls` (
  `uid` int unsigned NOT NULL,
  `pid` int unsigned NOT NULL,
  `attempts` int NOT NULL default 1,
  `short_interpretation` tinytext NOT NULL default '',
  `long_interpretation` text NOT NULL default '',
  `serialized_interpretation` text NOT NULL default '',
  PRIMARY KEY user_poll (uid,pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_users`;
CREATE TABLE `qp_users` (
  `uid` int unsigned NOT NULL auto_increment,
  `name` tinytext NOT NULL,
  PRIMARY KEY unique_name (uid,name(64)),
  INDEX user_id (uid),
  INDEX username (name(64))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_random_questions`;
CREATE TABLE `qp_random_questions` (
  `uid` int unsigned NOT NULL,
  `pid` int unsigned NOT NULL,
  `question_id` int unsigned NOT NULL,
  PRIMARY KEY user_poll_question (uid,pid,question_id),
  INDEX user_seed (uid,pid),
  INDEX poll (pid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
