--- SQL tables for the Comments extension
--- This was coppied from halo DB fo convenience
--- Note that some tables are used by other SocialTools

CREATE TABLE IF NOT EXISTS `Comments` (
  `CommentID` int(11) NOT NULL auto_increment,
  `Comment_Page_ID` int(11) NOT NULL default '0',
  `Comment_user_id` int(11) NOT NULL default '0',
  `Comment_Username` varchar(200) NOT NULL default '',
  `Comment_Text` text NOT NULL,
  `Comment_Date` datetime NOT NULL default '0000-00-00 00:00:00',
  `Comment_Parent_ID` int(11) NOT NULL default '0',
  `Comment_IP` varchar(45) NOT NULL default '',
  `Comment_Plus_Count` int(11) NOT NULL default '0',
  `Comment_Minus_Count` int(11) NOT NULL default '0',
  PRIMARY KEY  (`CommentID`),
  KEY `comment_page_id_index` (`Comment_Page_ID`),
  KEY `wiki_user_id` (`Comment_user_id`),
  KEY `wiki_user_name` (`Comment_Username`),
  KEY `pluscontidx` (`Comment_user_id`),
  KEY `miuscountidx` (`Comment_Plus_Count`),
  KEY `comment_date` (`Comment_Minus_Count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user_stats` (
  `stats_year_id` int(2) NOT NULL default '0',
  `stats_user_id` int(11) NOT NULL default '0',
  `stats_user_name` varchar(255) NOT NULL default '',
  `stats_user_image_count` int(11) NOT NULL default '0',
  `stats_comment_count` int(11) NOT NULL default '0',
  `stats_comment_score` int(11) NOT NULL default '0',
  `stats_comment_score_positive_rec` int(11) NOT NULL default '0',
  `stats_comment_score_negative_rec` int(11) NOT NULL default '0',
  `stats_comment_score_positive_given` int(11) NOT NULL default '0',
  `stats_comment_score_negative_given` int(11) NOT NULL default '0',
  `stats_comment_blocked` int(11) NOT NULL default '0',
  `stats_vote_count` int(11) NOT NULL default '0',
  `stats_edit_count` int(11) NOT NULL default '0',
  `stats_opinions_created` int(11) NOT NULL default '0',
  `stats_opinions_published` int(11) NOT NULL default '0',
  `stats_referrals` int(11) NOT NULL default '0',
  `stats_referrals_completed` int(11) NOT NULL default '0',
  `stats_challenges_count` int(11) NOT NULL default '0',
  `stats_challenges_won` int(11) NOT NULL default '0',
  `stats_challenges_rating_positive` int(11) NOT NULL default '0',
  `stats_challenges_rating_negative` int(11) NOT NULL default '0',
  `stats_friends_count` int(11) NOT NULL default '0',
  `stats_foe_count` int(11) NOT NULL default '0',
  `stats_gifts_rec_count` int(11) NOT NULL default '0',
  `stats_gifts_sent_count` int(11) NOT NULL default '0',
  `stats_weekly_winner_count` int(11) NOT NULL default '0',
  `stats_monthly_winner_count` int(11) NOT NULL default '0',
  `stats_total_points` int(20) default '0',
  `stats_overall_rank` int(11) NOT NULL default '0',
  `up_complete` int(5) default NULL,
  `user_board_count` int(5) default '0',
  `user_board_sent` int(5) default '0',
  `user_board_count_priv` int(5) default '0',
  `stats_picturegame_votes` int(5) default '0',
  `stats_picturegame_created` int(5) default '0',
  `user_status_count` int(5) default '0',
  `stats_poll_votes` int(5) default '0',
  `user_status_agree` int(11) default '0',
  `stats_quiz_questions_answered` int(11) default '0',
  `stats_quiz_questions_correct` int(11) default '0',
  `stats_quiz_points` int(11) default '0',
  `stats_quiz_questions_created` int(11) default '0',
  `stats_quiz_questions_correct_percent` float default '0',
  PRIMARY KEY  (`stats_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `Comments_Vote` (
  `Comment_Vote_ID` int(11) NOT NULL default '0',
  `Comment_Vote_user_id` int(11) NOT NULL default '0',
  `Comment_Vote_Username` varchar(200) NOT NULL default '',
  `Comment_Vote_Score` int(4) NOT NULL default '0',
  `Comment_Vote_Date` datetime NOT NULL default '0000-00-00 00:00:00',
  `Comment_Vote_IP` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`Comment_Vote_ID`,`Comment_Vote_Username`),
  KEY `Comment_Vote_Score` (`Comment_Vote_Score`),
  KEY `Comment_Vote_user_id` (`Comment_Vote_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `Comments_block` (
  `cb_id` int(11) NOT NULL auto_increment,
  `cb_user_id` int(5) NOT NULL default '0',
  `cb_user_name` varchar(255) NOT NULL default '',
  `cb_user_id_blocked` int(5) default NULL,
  `cb_user_name_blocked` varchar(255) NOT NULL default '',
  `cb_date` datetime default NULL,
  PRIMARY KEY  (`cb_id`),
  KEY `cb_user_id` (`cb_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `wikia_page_stats` (
  `ps_page_id` int(11) NOT NULL default '0',
  `vote_count` int(11) NOT NULL default '0',
  `comment_count` int(11) NOT NULL default '0',
  `vote_avg` float default NULL,
  PRIMARY KEY  (`ps_page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `system_gift` (
  `gift_id` int(11) NOT NULL auto_increment,
  `gift_name` varchar(255) NOT NULL default '',
  `gift_description` text,
  `gift_given_count` int(11) default '0',
  `gift_category` int(11) default '0',
  `gift_threshold` int(15) default '0',
  `gift_createdate` datetime default NULL,
  PRIMARY KEY  (`gift_id`),
  KEY `giftcategoryidx` (`gift_category`),
  KEY `giftthresholdidx` (`gift_threshold`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `Vote` (
  `vote_id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL default '0',
  `vote_user_id` int(11) NOT NULL default '0',
  `vote_page_id` int(11) NOT NULL default '0',
  `vote_value` char(1) character set latin1 collate latin1_bin NOT NULL default '',
  `vote_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_ip` varchar(45) NOT NULL default '',
  PRIMARY KEY  (`vote_id`),
  KEY `vote_page_id_index` (`vote_page_id`),
  KEY `valueidx` (`vote_value`),
  KEY `usernameidx` (`username`),
  KEY `vote_date` (`vote_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `published_level` (
  `published_level_id` int(4) NOT NULL default '0',
  `published_score` int(4) NOT NULL default '0',
  `published_level_desc` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`published_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
