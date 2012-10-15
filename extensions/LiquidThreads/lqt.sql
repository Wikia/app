CREATE TABLE /*$wgDBprefix*/thread (
  thread_id int(8) unsigned NOT NULL PRIMARY KEY auto_increment,
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

  UNIQUE (thread_root)
) /*$wgDBTableOptions*/;
CREATE INDEX thread_ancestor ON /*$wgDBprefix*/thread (thread_ancestor, thread_parent);
CREATE INDEX thread_article_title ON /*$wgDBprefix*/thread (thread_article_namespace, thread_article_title, thread_sortkey);
CREATE INDEX thread_article ON /*$wgDBprefix*/thread (thread_article_id, thread_sortkey);
CREATE INDEX thread_modified ON /*$wgDBprefix*/thread (thread_modified);
CREATE INDEX thread_created ON /*$wgDBprefix*/thread (thread_created);
CREATE INDEX thread_summary_page ON /*$wgDBprefix*/thread (thread_summary_page);
CREATE INDEX thread_author_name ON /*$wgDBprefix*/thread (thread_author_id,thread_author_name);
CREATE INDEX thread_sortkey ON /*$wgDBprefix*/thread (thread_sortkey);

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

  PRIMARY KEY (hthread_id, hthread_revision) 
) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/user_message_state (
  ums_user int unsigned NOT NULL,
  ums_thread int(8) unsigned NOT NULL,
  ums_conversation int(8) unsigned NOT NULL DEFAULT 0,
  ums_read_timestamp varbinary(14),

  PRIMARY KEY (ums_user, ums_thread)
) /*$wgDBTableOptions*/;
CREATE INDEX ums_user_conversation ON /*$wgDBprefix*/user_message_state (ums_user,ums_conversation);

-- "New" storage location for history data.
CREATE TABLE /*_*/thread_history (
	th_id int unsigned NOT NULL PRIMARY KEY auto_increment,
	th_thread int unsigned NOT NULL,

	th_timestamp varbinary(14) NOT NULL,

	th_user int unsigned NOT NULL,
	th_user_text varchar(255) NOT NULL,

	th_change_type int unsigned NOT NULL,
	th_change_object int unsigned NOT NULL,
	th_change_comment TINYTEXT NOT NULL,

	-- Actual content, stored as a serialised thread row.
	th_content LONGBLOB NOT NULL
) /*$wgDBTableOptions*/;
CREATE INDEX th_thread_timestamp ON /*$wgDBprefix*/thread_history (th_thread,th_timestamp);
CREATE INDEX th_timestamp_thread ON /*$wgDBprefix*/thread_history (th_timestamp,th_thread);
CREATE INDEX th_user_text ON /*$wgDBprefix*/thread_history (th_user,th_user_text);

-- Storage for "pending" relationships from import
CREATE TABLE /*_*/thread_pending_relationship (
	tpr_thread int unsigned NOT NULL,
	tpr_relationship varbinary(64) NOT NULL,
	tpr_title varbinary(255) NOT NULL,
	tpr_type varbinary(32) NOT NULL,
	PRIMARY KEY (tpr_thread,tpr_relationship)
) /*$wgDBTableOptions*/;

-- Storage for reactions
CREATE TABLE /*_*/thread_reaction (
	tr_thread int unsigned NOT NULL,
	tr_user int unsigned NOT NULL,
	tr_user_text varbinary(255) NOT NULL,
	tr_type varbinary(64) NOT NULL,
	tr_value int NOT NULL,

	PRIMARY KEY (tr_thread,tr_user,tr_user_text,tr_type,tr_value)
) /*$wgDBTableOptions*/;
CREATE INDEX tr_user_text_value ON /*$wgDBprefix*/thread_reaction (tr_user,tr_user_text,tr_type,tr_value);
