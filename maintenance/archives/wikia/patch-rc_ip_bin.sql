-- SUS-3079: Create rc_ip_bin column and index for recentchanges table

ALTER TABLE /*$wgDBPrefix*/recentchanges
  ADD rc_ip_bin VARBINARY(16) NULL DEFAULT NULL;

CREATE INDEX /*i*/rc_ip_bin ON /*_*/recentchanges (rc_ip_bin);
