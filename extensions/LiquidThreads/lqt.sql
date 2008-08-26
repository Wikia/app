CREATE TABLE /*$wgDBprefix*/thread (
  thread_id int(8) unsigned NOT NULL auto_increment,
  thread_root int(8) unsigned UNIQUE NOT NULL,
  thread_ancestor int(8) unsigned NOT NULL,
  thread_parent int(8) unsigned NULL,
  thread_summary_page int(8) unsigned NULL,

  thread_modified char(14) binary NOT NULL default '',
  thread_created char(14) binary NOT NULL default '',
  thread_revision int(8) unsigned NOT NULL default 1,

  thread_editedness int(1) NOT NULL default 0,

  thread_article_namespace int NOT NULL,
  thread_article_title varchar(255) binary NOT NULL,

  -- Special thread types such as schrodinger's thread:
  thread_type int(4) unsigned NOT NULL default 0,

  thread_change_type int(4) unsigned NOT NULL,
  thread_change_object int(8) unsigned NULL,
  thread_change_comment tinyblob NOT NULL,
  thread_change_user int unsigned NOT NULL default '0',
  thread_change_user_text varchar(255) binary NOT NULL default '',

  PRIMARY KEY thread_id (thread_id),
  UNIQUE INDEX thread_id (thread_id),
  INDEX thread_ancestor (thread_ancestor),
  INDEX thread_article_title (thread_article_namespace, thread_article_title),
  INDEX thread_modified (thread_modified),
  INDEX thread_created (thread_created),
  INDEX thread_summary_page (thread_summary_page)
) TYPE=InnoDB;

CREATE TABLE /*$wgDBprefix*/historical_thread (
  -- Note that many hthreads can share an id, which is the same as the id
  -- of the live thread. It is only the id/revision combo which must be unique.
  hthread_id int(8) unsigned NOT NULL,
  hthread_revision int(8) unsigned NOT NULL,
  hthread_contents BLOB NOT NULL,
  hthread_change_type int(4) unsigned NOT NULL,
  hthread_change_object int(8) unsigned NULL,
  PRIMARY KEY hthread_id_revision (hthread_id, hthread_revision)
) TYPE=InnoDB;

CREATE TABLE /*$wgDBprefix*/user_message_state (
  ums_user int unsigned NOT NULL,
  ums_thread int(8) unsigned NOT NULL,
  ums_read_timestamp varbinary(14),
  
  PRIMARY KEY (ums_user, ums_thread)
) TYPE=InnoDB;
