CREATE TABLE /*$wgDBprefix*/thread (
  thread_id int(8) unsigned NOT NULL auto_increment,
  thread_root int(8) unsigned UNIQUE NOT NULL,
  thread_ancestor int(8) unsigned NOT NULL,
  thread_parent int(8) unsigned NULL,
  thread_summary_page int(8) unsigned NULL,
  thread_subject varchar(255) NULL,
  thread_author_id int unsigned NULL,
  thread_author_name varchar(255) NULL,

  thread_modified char(14) binary NOT NULL default '',
  thread_created char(14) binary NOT NULL default '',

  thread_editedness int(1) NOT NULL default 0,

  thread_article_namespace int NOT NULL,
  thread_article_title varchar(255) binary NOT NULL,
  thread_article_id int(8) unsigned NOT NULL,

  -- Special thread types (deleted/move trace/normal)
  thread_type int(4) unsigned NOT NULL default 0,
  
  -- Sort key
  thread_sortkey varchar(255) NOT NULL default '',
  
  -- Reply count, -1 means uninitialised.
  thread_replies int(8) DEFAULT -1,
  
  -- Signature
  thread_signature TINYBLOB NULL,

  PRIMARY KEY thread_id (thread_id),
  UNIQUE INDEX thread_root_page (thread_root),
  INDEX thread_ancestor (thread_ancestor, thread_parent),
  INDEX thread_article_title (thread_article_namespace, thread_article_title, thread_sortkey),
  INDEX thread_article (thread_article_id, thread_sortkey),
  INDEX thread_modified (thread_modified),
  INDEX thread_created (thread_created),
  INDEX thread_summary_page (thread_summary_page),
  INDEX (thread_author_id,thread_author_name),
  INDEX (thread_sortkey)
) /*$wgDBTableOptions*/;


-- Old storage table for "historical" (i.e. non-current) threads
-- Now superseded by thread_history.
CREATE TABLE /*$wgDBprefix*/historical_thread (
  -- Note that many hthreads can share an id, which is the same as the id
  -- of the live thread. It is only the id/revision combo which must be unique.
  hthread_id int(8) unsigned NOT NULL,
  hthread_revision int(8) unsigned NOT NULL,
  hthread_contents BLOB NOT NULL,
  hthread_change_type int(4) unsigned NOT NULL,
  hthread_change_object int(8) unsigned NULL,
  PRIMARY KEY hthread_id_revision (hthread_id, hthread_revision)
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/user_message_state (
  ums_user int unsigned NOT NULL,
  ums_thread int(8) unsigned NOT NULL,
  ums_read_timestamp varbinary(14),

  PRIMARY KEY (ums_user, ums_thread),
  KEY (ums_user,ums_read_timestamp)
) /*$wgDBTableOptions*/;

-- "New" storage location for history data.
CREATE TABLE /*_*/thread_history (
	th_id int unsigned NOT NULL auto_increment,
	th_thread int unsigned NOT NULL,
	
	th_timestamp varbinary(14) NOT NULL,
	
	th_user int unsigned NOT NULL,
	th_user_text varchar(255) NOT NULL,
	
	th_change_type int unsigned NOT NULL,
	th_change_object int unsigned NOT NULL,
	th_change_comment TINYTEXT NOT NULL,
	
	-- Actual content, stored as a serialised thread row.
	th_content LONGBLOB NOT NULL,
	
	PRIMARY KEY (th_id),
	KEY (th_thread,th_timestamp),
	KEY (th_timestamp,th_thread),
	KEY (th_user,th_user_text)
) /*$wgDBTableOptions*/;
