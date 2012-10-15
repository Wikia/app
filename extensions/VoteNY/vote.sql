CREATE TABLE /*_*/Vote (
  -- Internal ID to identify between different vote tags on different pages
  `vote_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  -- Username (if any) of the person who voted
  `username` varchar(255) NOT NULL default '0',
  -- User ID of the person who voted
  `vote_user_id` int(11) NOT NULL default '0',
  -- ID of the page where the vote tag is in
  `vote_page_id` int(11) NOT NULL default '0',
  -- Value of the vote (ranging from 1 to 5)
  `vote_value` char(1) character set latin1 collate latin1_bin NOT NULL default '',
  -- Timestamp when the vote was cast
  `vote_date` datetime NOT NULL default '0000-00-00 00:00:00',
  -- IP address of the user who voted
  `vote_ip` varchar(45) NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE INDEX vote_page_id_index ON /*_*/Vote (vote_page_id);
CREATE INDEX valueidx ON /*_*/Vote (vote_value);
CREATE INDEX usernameidx ON /*_*/Vote (username);
CREATE INDEX vote_date ON /*_*/Vote (vote_date);