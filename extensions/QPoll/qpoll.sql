/* WARNING: do not use directly in case your wiki DB setup uses table prefixes
 * use Special:PollResults page instead
 * this file is primarily for debugging
 */

DROP TABLE IF EXISTS `qp_poll_desc`;
CREATE TABLE `qp_poll_desc` (
  `pid` int unsigned NOT NULL auto_increment,
  `article_id` int unsigned NOT NULL,
  `poll_id` tinytext NOT NULL,
  `order_id` int unsigned NOT NULL,
  `dependance` mediumtext NOT NULL,
  PRIMARY KEY poll (pid),
  UNIQUE INDEX article_poll (article_id,poll_id(128))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_question_desc`;
CREATE TABLE `qp_question_desc` (
  `pid` int unsigned NOT NULL,
  `question_id` int unsigned NOT NULL,
  `type` tinytext NOT NULL,
  `common_question` mediumtext NOT NULL,
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
  `proposal_text` tinytext NOT NULL,
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
  `text_answer` mediumtext,
  PRIMARY KEY answer (uid,pid,question_id,proposal_id,cat_id),
  INDEX user_vote (uid,pid),
  INDEX poll_question (pid,question_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `qp_users_polls`;
CREATE TABLE `qp_users_polls` (
  `uid` int unsigned NOT NULL,
  `pid` int unsigned NOT NULL,
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
