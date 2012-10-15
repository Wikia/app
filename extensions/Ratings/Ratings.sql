-- MySQL version of the database schema for the Ratings extension.

-- Special translations table.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/votes (
  vote_id                 INT(10) unsigned    NOT NULL auto_increment PRIMARY KEY,
  vote_page_id            INT(10) unsigned    NOT NULL,
  vote_prop_id            INT(5) unsigned     NOT NULL,
  vote_user_text          VARCHAR(255) binary NOT NULL default '',  
  vote_value              INT(4) unsigned     NOT NULL,
  vote_time               CHAR(14) binary     NOT NULL default ''
) /*$wgDBTableOptions*/; 

-- Table to keep track of translation memories for the special words.
CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/vote_props (
  prop_id                 INT(5) unsigned     NOT NULL auto_increment PRIMARY KEY,
  prop_name               VARCHAR(255)        NOT NULL
) /*$wgDBTableOptions*/;