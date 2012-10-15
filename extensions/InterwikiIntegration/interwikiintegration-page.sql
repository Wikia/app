CREATE TABLE /*_*/integration_page (
  -- Primary key.
  integration_global_page_id int unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  
  -- Database name.
  integration_page_db varchar(255) binary NOT NULL,
  
  -- Unique identifier number. The integration_page_id will be preserved across
  -- edits and rename operations, but not deletions and recreations.
  integration_page_id int unsigned NOT NULL,
  
  -- A page name is broken into a namespace and a title.
  -- The namespace keys are UI-language-independent constants,
  -- defined in includes/Defines.php
  integration_page_namespace int NOT NULL,
  
  -- The rest of the title, as text.
  -- Spaces are transformed into underscores in title storage.
  integration_page_title varchar(255) binary NOT NULL,
  
  -- Comma-separated set of permission keys indicating who
  -- can move or edit the page.
  integration_page_restrictions tinyblob NOT NULL,
  
  -- Number of times this page has been viewed.
  integration_page_counter bigint unsigned NOT NULL default 0,
  
  -- 1 indicates the article is a redirect.
  integration_page_is_redirect tinyint unsigned NOT NULL default 0,
  
  -- 1 indicates this is a new entry, with only one edit.
  -- Not all pages with one edit are new pages.
  integration_page_is_new tinyint unsigned NOT NULL default 0,
  
  -- Random value between 0 and 1, used for Special:Randompage
  integration_page_random real unsigned NOT NULL,
  
  -- This timestamp is updated whenever the page changes in
  -- a way requiring it to be re-rendered, invalidating caches.
  -- Aside from editing this includes permission changes,
  -- creation or deletion of linked pages, and alteration
  -- of contained templates.
  integration_page_touched binary(14) NOT NULL default '',

  -- Handy key to revision.rev_id of the current revision.
  -- This may be 0 during page creation, but that shouldn't
  -- happen outside of a transaction... hopefully.
  integration_page_latest int unsigned NOT NULL,
  
  -- Uncompressed length in bytes of the page's current source text.
  integration_page_len int unsigned NOT NULL
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/integration_name_title ON /*_*/integration_page (integration_page_namespace,integration_page_title,integration_page_db);
CREATE INDEX /*i*/integration_page_random ON /*_*/integration_page (integration_page_random);
CREATE INDEX /*i*/integration_page_len ON /*_*/integration_page (integration_page_len);