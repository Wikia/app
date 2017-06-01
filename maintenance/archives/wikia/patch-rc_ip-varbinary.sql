-- SUS-1947: Update rc_ip field to match MW 1.19 schema on ancient wikis

ALTER TABLE /*$wgDBprefix*/recentchanges
  MODIFY COLUMN rc_ip varbinary(40);
