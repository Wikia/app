CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cl_errors (
  `cle_id` int(10) unsigned NOT NULL PRIMARY KEY auto_increment,
  `cle_zip` int(5) unsigned NOT NULL,
  `cle_comment` varchar(255) DEFAULT NULL
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/cle_zip ON /*$wgDBprefix*/cl_errors (cle_zip);
