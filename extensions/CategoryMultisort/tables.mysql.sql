--
-- Track category inclusions with more than one sortkey defined
-- If an inclusion is recorded here, it must be recorded in categorylinks table as well
--
CREATE TABLE /*_*/categorylinks_multisort (
  -- Key to page_id of the page defined as a category member.
  clms_from int unsigned NOT NULL default 0,
  
  -- Name of the category.
  -- This is also the page_title of the category's description page;
  -- all such pages are in namespace 14 (NS_CATEGORY).
  clms_to varchar(255) binary NOT NULL default '',
  
  -- clms_sortkey_name is A and clms_sortkey is B when [[Category:C|A=B]] is used
  clms_sortkey_name varchar(70) binary NOT NULL default '',
  clms_sortkey varchar(255) binary NOT NULL default ''
) /*$wgDBTableOptions*/;

CREATE UNIQUE INDEX /*i*/clms_from ON /*_*/categorylinks_multisort (clms_from,clms_to,clms_sortkey_name);

-- We always sort within a given category...
CREATE INDEX /*i*/clms_sortkey ON /*_*/categorylinks_multisort (clms_to,clms_sortkey,clms_sortkey_name,clms_from);
