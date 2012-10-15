CREATE TABLE /*_*/ext_meta (
  `pageid` INT(8) NOT NULL,
  `rindex` tinyint(1) NOT NULL,
  `rfollow` tinyint(1) NOT NULL,
  `titlealias` VARCHAR(255),
  `keywords` text,
  `description` text,
  PRIMARY KEY  (`pageid`)
) /*$wgDBTableOptions*/;