-- Three tables for PollNY extension
CREATE TABLE /*_*/poll_choice (
  `pc_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `pc_poll_id` int(11) NOT NULL default '0',
  `pc_order` int(5) default '0',
  `pc_text` text NOT NULL,
  `pc_vote_count` text NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/pc_poll_id ON /*_*/poll_choice (pc_poll_id);

CREATE TABLE /*_*/poll_question (
  `poll_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `poll_page_id` int(11) NOT NULL default '0',
  `poll_user_id` int(11) NOT NULL default '0',
  `poll_user_name` varchar(255) NOT NULL default '',
  `poll_text` text NOT NULL,
  `poll_image` varchar(255) NOT NULL default '',
  `poll_status` int(5) default '1',
  `poll_vote_count` int(5) default '0',
  `poll_question_vote_count` int(5) default '0',
  -- MW standard version for timestamps:
  --`poll_date` binary(14) NOT NULL default '',
  `poll_date` datetime default NULL,
  `poll_random` double unsigned default '0'
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/poll_user_id ON /*_*/poll_question (poll_user_id);
CREATE INDEX /*i*/poll_random ON /*_*/poll_question (poll_random);

CREATE TABLE /*_*/poll_user_vote (
  `pv_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `pv_poll_id` int(11) NOT NULL default '0',
  `pv_pc_id` int(5) default '0',
  `pv_user_id` int(11) NOT NULL default '0',
  `pv_user_name` varchar(255) NOT NULL default '',
  `pv_date` datetime default NULL
  -- MW standard version for timestamps:
  --`pv_date` binary(14) NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/pv_user_id ON /*_*/poll_user_vote (pv_user_id);
CREATE INDEX /*i*/pv_poll_id ON /*_*/poll_user_vote (pv_poll_id);
CREATE INDEX /*i*/pv_pc_id ON /*_*/poll_user_vote (pv_pc_id);