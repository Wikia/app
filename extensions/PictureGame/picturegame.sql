-- Required tables for the PictureGame extension
CREATE TABLE /*_*/picturegame_images (
  `id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY,
  -- Both of these were originally varchar(64)
  `img1` varchar(255) NOT NULL default '',
  `img2` varchar(255) NOT NULL default '',
  -- old version:
  --`flag` enum('NONE','PROTECT','FLAGGED') NOT NULL default 'NONE',
  `flag` tinyint(2) NOT NULL default '0',
  -- Originally varchar(64)
  `title` varchar(255) NOT NULL default '',
  `img1_caption` varchar(255) NOT NULL default '',
  `img2_caption` varchar(255) NOT NULL default '',
  `userid` int(10) unsigned NOT NULL default '0',
  -- Originally varchar(64)
  `username` varchar(255) NOT NULL default '',
  `img0_votes` int(10) unsigned NOT NULL default '0',
  `img1_votes` int(10) unsigned NOT NULL default '0',
  `heat` double NOT NULL default '0',
  `pg_date` datetime default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/userid ON /*_*/picturegame_images (userid);

CREATE TABLE /*_*/picturegame_votes (
  `picid` int(10) unsigned NOT NULL default '0',
  `userid` int(5) default NULL,
  `imgpicked` int(1) unsigned NOT NULL default '0',
  `id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY,
  `username` varchar(255) default NULL,
  `vote_date` datetime default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/picturegame_username ON /*_*/picturegame_votes (username);
CREATE INDEX /*i*/picturegame_pic_id ON /*_*/picturegame_votes (picid);