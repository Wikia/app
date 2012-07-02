-- Replace /*_*/ with the proper prefix
-- Replace /*$wgDBTableOptions*/ with the correct options

CREATE TABLE IF NOT EXISTS /*_*/shorturls (    
	su_id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
	su_namespace integer NOT NULL,
	su_title varchar(255) NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/shorturls_ns_title ON /*_*/shorturls (su_namespace, su_title);
