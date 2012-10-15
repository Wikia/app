--
-- Table structure for table `user_board`
--

CREATE TABLE /*_*/user_board (
  `ub_id` int(11) PRIMARY KEY auto_increment,
  `ub_user_id` int(11) NOT NULL default '0',
  `ub_user_name` varchar(255) NOT NULL default '',
  `ub_user_id_from` int(11) NOT NULL default '0',
  `ub_user_name_from` varchar(255) NOT NULL default '',
  `ub_message` text NOT NULL,
  `ub_type` int(5) default '0',
  `ub_date` datetime default NULL
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/ub_user_id ON      /*_*/user_board (ub_user_id);
CREATE INDEX /*i*/ub_user_id_from ON /*_*/user_board (ub_user_id_from);
CREATE INDEX /*i*/ub_type ON         /*_*/user_board (ub_type);
