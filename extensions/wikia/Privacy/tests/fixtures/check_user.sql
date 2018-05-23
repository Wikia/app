-- Tables for the CheckUser extension
-- vim: autoindent syn=mysql sts=2 sw=2
-- Replace /*$wgDBprefix*/ with the proper prefix

CREATE TABLE /*$wgDBprefix*/cu_changes (
  -- Primary key
  cuc_id INTEGER NOT NULL PRIMARY KEY autoincrement,

  -- When pages are renamed, their RC entries do _not_ change.
  cuc_namespace int NOT NULL default '0',
  cuc_title varchar(255) NOT NULL default '',

  -- user.user_id
  cuc_user INTEGER NOT NULL DEFAULT 0,
  -- cuc_user_text VARCHAR(255) NOT NULL DEFAULT '', -- SUS-3080 - this column is redundant (use either cuc_user or cuc_ip)

  -- Edit summary
  cuc_actiontext varchar(255) NOT NULL default '',
  cuc_comment varchar(255) NOT NULL default '',
  cuc_minor bool NOT NULL default '0',

  -- Key to page_id (was cur_id prior to 1.5).
  -- This will keep links working after moves while
  -- retaining the at-the-time name in the changes list.
  cuc_page_id int(10) NOT NULL default '0',

  -- rev_id of the given revision
  cuc_this_oldid int(10) NOT NULL default '0',

  -- rev_id of the prior revision, for generating diff links.
  cuc_last_oldid int(10) NOT NULL default '0',

  -- Edit/new/log
  cuc_type tinyint(3) NOT NULL default '0',

  -- Event timestamp
  cuc_timestamp CHAR(14) NOT NULL default '',

  -- IP address, visible
  cuc_ip VARCHAR(255) default '',

  -- IP address as hexidecimal
  cuc_ip_hex VARCHAR(255) default NULL,

  -- XFF header, visible, all data
  cuc_xff VARCHAR(255) default '',

  -- XFF header, last IP, as hexidecimal
  cuc_xff_hex VARCHAR(255) default NULL,

  -- User agent
  cuc_agent VARCHAR(255) default NULL

) /*$wgDBTableOptions*/;

CREATE TABLE /*$wgDBprefix*/cu_log (
  -- Unique identifier
  cul_id int unsigned not null PRIMARY KEY AUTOINCREMENT ,

  -- Timestamp of CheckUser action
  cul_timestamp binary(14) not null,

  -- User who performed the action
  cul_user int unsigned not null,
  cul_user_text varchar(255) not null,

  -- Reason given
  cul_reason varchar(255) not null,

  -- String indicating the type of query, may be "userips", "ipedits", "ipusers", "ipedits-xff", "ipusers-xff"
  cul_type varbinary(30) not null,

  -- Integer target, interpretation depends on cul_type
  -- For username targets, this is the user_id
  cul_target_id int unsigned not null default 0,

  -- Text target, interpretation depends on cul_type
  cul_target_text blob not null,

  -- If the target was an IP address, this contains the hexadecimal form of the IP
  cul_target_hex varbinary(255) not null default '',
  -- If the target was an IP range, these fields contain the start and end, in hex form
  cul_range_start varbinary(255) not null default '',
  cul_range_end varbinary(255) not null default ''

) /*$wgDBTableOptions*/;
