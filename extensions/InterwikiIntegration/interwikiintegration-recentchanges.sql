BEGIN;

--
-- Primarily a summary table for Special:InterwikiRecentchanges,
-- this table contains some additional info on edits from
-- the last few days, see Article::editUpdates()
--
CREATE TABLE /*_*/integration_recentchanges (
  integration_rc_global_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  
  -- Local rc_id
  integration_rc_id int NOT NULL,
  
  -- Database name of the wiki
  integration_rc_db varchar(255) binary NOT NULL,
  
  integration_rc_timestamp varbinary(14) NOT NULL default '',
  integration_rc_cur_time varbinary(14) NOT NULL default '',
  
  -- As in revision
  integration_rc_user int unsigned NOT NULL default 0,
  integration_rc_user_text varchar(255) binary NOT NULL,
  
  -- When pages are renamed, their RC entries do _not_ change.
  integration_rc_namespace int NOT NULL default 0,
  integration_rc_title varchar(255) binary NOT NULL default '',
  
  -- as in revision...
  integration_rc_comment varchar(255) binary NOT NULL default '',
  integration_rc_minor tinyint unsigned NOT NULL default 0,
  
  -- Edits by user accounts with the 'bot' rights key are
  -- marked with a 1 here, and will be hidden from the
  -- default view.
  integration_rc_bot tinyint unsigned NOT NULL default 0,
  
  integration_rc_new tinyint unsigned NOT NULL default 0,
  
  -- Key to page_id (was cur_id prior to 1.5).
  -- This will keep links working after moves while
  -- retaining the at-the-time name in the changes list.
  integration_rc_cur_id int unsigned NOT NULL default 0,
  
  -- rev_id of the given revision
  integration_rc_this_oldid int unsigned NOT NULL default 0,
  
  -- rev_id of the prior revision, for generating diff links.
  integration_rc_last_oldid int unsigned NOT NULL default 0,
  
  -- These may no longer be used, with the new move log.
  integration_rc_type tinyint unsigned NOT NULL default 0,
  integration_rc_moved_to_ns tinyint unsigned NOT NULL default 0,
  integration_rc_moved_to_title varchar(255) binary NOT NULL default '',
  
  -- If the Recent Changes Patrol option is enabled,
  -- users may mark edits as having been reviewed to
  -- remove a warning flag on the RC list.
  -- A value of 1 indicates the page has been reviewed.
  integration_rc_patrolled tinyint unsigned NOT NULL default 0,
  
  -- Recorded IP address the edit was made from, if the
  -- $wgPutIPinRC option is enabled.
  integration_rc_ip varbinary(40) NOT NULL default '',
  
  -- Text length in characters before
  -- and after the edit
  integration_rc_old_len int,
  integration_rc_new_len int,

  -- Visibility of recent changes items, bitfield
  integration_rc_deleted tinyint unsigned NOT NULL default 0,

  -- Value corresonding to log_id, specific log entries
  integration_rc_logid int unsigned NOT NULL default 0,
  -- Store log type info here, or null
  integration_rc_log_type varbinary(255) NULL default NULL,
  -- Store log action or null
  integration_rc_log_action varbinary(255) NULL default NULL,
  -- Log params
  integration_rc_params blob NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/integration_rc_timestamp ON integration_recentchanges (integration_rc_timestamp);
CREATE INDEX /*i*/integration_rc_namespace_title ON integration_recentchanges (integration_rc_namespace, integration_rc_title);
CREATE INDEX /*i*/integration_rc_cur_id ON integration_recentchanges (integration_rc_cur_id);
CREATE INDEX /*i*/integration_new_name_timestamp ON integration_recentchanges (integration_rc_new,integration_rc_namespace,integration_rc_timestamp);
CREATE INDEX /*i*/integration_rc_ip ON integration_recentchanges (integration_rc_ip);
CREATE INDEX /*i*/integration_rc_ns_usertext ON integration_recentchanges (integration_rc_namespace, integration_rc_user_text);
CREATE INDEX /*i*/integration_rc_user_text ON integration_recentchanges (integration_rc_user_text, integration_rc_timestamp);

COMMIT;