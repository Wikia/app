-- Run the following SQL on your database prior to use :

CREATE TABLE stableversions (
  sv_page_id int(8) unsigned NOT NULL default '0',
  sv_page_rev int(8) unsigned NOT NULL default '0',
  sv_type tinyint(2) unsigned NOT NULL default '0',
  sv_user int(8) unsigned NOT NULL default '0',
  sv_date varchar(14) NOT NULL default '',
  sv_cache mediumblob NOT NULL,
  KEY sv_page_id (sv_page_id,sv_page_rev,sv_type)
) TYPE=InnoDB;