CREATE TABLE `quizgame_questions` (
  `q_id` int(11) unsigned NOT NULL auto_increment,
  `q_user_id` int(11) unsigned NOT NULL default '0',
  `q_user_name` varchar(255) NOT NULL default '',
  `q_flag` enum('NONE','PROTECT','FLAGGED') NOT NULL default 'NONE',
  `q_text` varchar(255) NOT NULL default '',
  `q_answer_count` int(11) default '0',
  `q_answer_correct_count` int(11) default '0',
  `q_picture` varchar(45) NOT NULL default '',
  `q_date` datetime default NULL,
  `q_random` double unsigned default '0',
  `q_comment` varchar(255) default '',
  PRIMARY KEY  (`q_id`),
  KEY `q_user_id` (`q_user_id`),
  KEY `q_random` (`q_random`)
) ENGINE=InnoDB;

CREATE TABLE `quizgame_answers` (
  `a_id` int(10) unsigned NOT NULL auto_increment,
  `a_q_id` int(10) unsigned NOT NULL default '0',
  `a_choice_id` int(11) unsigned NOT NULL default '0',
  `a_user_id` int(11) unsigned NOT NULL default '0',
  `a_user_name` varchar(255) NOT NULL default '',
  `a_points` int(11) unsigned NOT NULL default '0',
  `a_date` datetime default NULL,
  PRIMARY KEY  (`a_id`),
  KEY `a_q_id` (`a_q_id`),
  KEY `a_choice_id` (`a_choice_id`),
  KEY `a_user_id` (`a_user_id`),
  KEY `a_user_name` (`a_user_name`)
) ENGINE=InnoDB;
