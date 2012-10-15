CREATE TABLE /*$wgDBprefix*/hidden (
  -- Page id from which this was taken.
  hidden_page int NOT NULL default '0',
  
  -- Page title at the time of suppression.
  -- Can be useful if the page is deleted and the id number becomes bad.
  hidden_namespace int NOT NULL default '0',
  hidden_title varchar(255) binary NOT NULL default '',
  
  -- Basic revision stuff...
  hidden_comment tinyblob NOT NULL,
  hidden_user int(5) unsigned NOT NULL default '0',
  hidden_user_text varchar(255) binary NOT NULL,
  hidden_timestamp char(14) binary NOT NULL default '',
  hidden_minor_edit tinyint(1) NOT NULL default '0',
  hidden_deleted tinyint(1) NOT NULL default '0',
  
  -- When revisions are deleted, their unique rev_id is stored
  -- here so it can be retained after undeletion. This is necessary
  -- to retain permalinks to given revisions after accidental delete
  -- cycles or messy operations like history merges.
  hidden_rev_id int(8) unsigned,
  
  -- This is the text.old_id key to the actual stored text. To avoid
  -- breaking the block-compression scheme and otherwise making storage
  -- changes harder, the actual text is *not* deleted from the text table,
  -- merely hidden by removal of the page and revision entries.
  --
  hidden_text_id int(8) unsigned,
  
  -- Information on the hiding itself
  hidden_by_user int,
  hidden_on_timestamp char(14) binary,
  hidden_reason text,
  
  KEY page_title_timestamp (hidden_page,hidden_timestamp),
  KEY name_title_timestamp (hidden_namespace,hidden_title,hidden_timestamp),
  KEY (hidden_on_timestamp),
  KEY (hidden_by_user,hidden_on_timestamp),
  KEY (hidden_user_text,hidden_timestamp)

) /*$wgDBTableOptions*/;
