CREATE TABLE /*$wgDBprefix*/indexes (
  -- The pageid of the page containing the parser function
  in_from int unsigned NOT NULL default 0,

  -- The NS/title that should redirect to the page
  in_namespace int NOT NULL default 0,
  in_title varchar(255) binary NOT NULL default '',

  KEY (in_from),
  KEY in_target (in_namespace, in_title)
) ENGINE=InnoDB;

