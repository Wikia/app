CREATE TABLE /*_*/tasks (
  task_id int(8) unsigned NOT NULL auto_increment,
  task_page_id int(8) unsigned NOT NULL default '0',
  task_page_title varchar(255) NOT NULL default '',
  task_user_id int(8) unsigned NOT NULL default '0',
  task_user_text varchar(255) NOT NULL default '',
  task_user_assigned int(8) unsigned NOT NULL default '0',
  task_status int(4) unsigned NOT NULL default '0',
  task_comment mediumtext NOT NULL,
  task_type int(4) unsigned NOT NULL default '0',
  task_timestamp varchar(14) binary NOT NULL default '',
  task_user_close int(8) unsigned NOT NULL default '0',
  task_timestamp_closed varchar(14) NOT NULL default '',
  PRIMARY KEY  (task_id),
  KEY task_page_id (task_page_id,task_status,task_type),
  KEY task_page_title (task_page_title)
) ENGINE=InnoDB;
