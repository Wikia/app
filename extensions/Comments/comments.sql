CREATE TABLE /*_*/Comments (
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

CREATE TABLE /*_*/Comments_Vote (
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

CREATE TABLE /*_*/Comments_block (
  `cb_id` int(11) NOT NULL auto_increment,
  `cb_user_id` int(5) NOT NULL default '0',
  `cb_user_name` varchar(255) NOT NULL default '',
  `cb_user_id_blocked` int(5) default NULL,
  `cb_user_name_blocked` varchar(255) NOT NULL default '',
  `cb_date` datetime default NULL,
  PRIMARY KEY  (`cb_id`),
  KEY `cb_user_id` (`cb_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;