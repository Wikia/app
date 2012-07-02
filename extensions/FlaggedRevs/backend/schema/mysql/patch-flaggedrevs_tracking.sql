-- Track includes/links only in stable versions
CREATE TABLE /*$wgDBprefix*/flaggedrevs_tracking (
  ftr_from integer unsigned NOT NULL default '0',
  ftr_namespace int NOT NULL default '0',
  ftr_title varchar(255) binary NOT NULL default '',
  PRIMARY KEY (ftr_from,ftr_namespace,ftr_title),
  INDEX namespace_title_from (ftr_namespace,ftr_title,ftr_from)
) /*$wgDBTableOptions*/;
