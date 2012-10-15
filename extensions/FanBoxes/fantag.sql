CREATE TABLE /*_*/fantag (
  `fantag_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `fantag_title` varchar(100) NOT NULL,
  `fantag_pg_id` int(11) NOT NULL,
  `fantag_left_text` varchar(20) default NULL,
  `fantag_left_textcolor` varchar(20) default NULL,
  `fantag_left_bgcolor` varchar(20) default NULL,
  `fantag_right_text` varchar(90) NOT NULL,
  `fantag_right_textcolor` varchar(20) default NULL,
  `fantag_right_bgcolor` varchar(20) default NULL,
  `fantag_user_id` int(11) NOT NULL,
  `fantag_user_name` varchar(50) NOT NULL,
  `fantag_date` datetime NOT NULL,
  `fantag_count` int(11) NOT NULL default '1',
  `fantag_image_name` varchar(255) default NULL,
  `fantag_left_textsize` varchar(20) default NULL,
  `fantag_right_textsize` varchar(20) default NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/fantag_user_id ON /*_*/fantag (fantag_user_id);
CREATE INDEX /*i*/fantag_pg_id ON /*_*/fantag (fantag_pg_id);

CREATE TABLE /*_*/user_fantag (
  `userft_id` int(11) NOT NULL auto_increment PRIMARY KEY,
  `userft_fantag_id` int(11) NOT NULL,
  `userft_user_id` int(11) NOT NULL,
  `userft_user_name` varchar(50) NOT NULL,
  `userft_date` datetime NOT NULL,
  `userft_order` int(11) NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/userft_fantag_id ON /*_*/user_fantag (userft_fantag_id);
CREATE INDEX /*i*/userft_user_id ON /*_*/user_fantag (userft_user_id);