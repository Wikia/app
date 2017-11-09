-- SUS-3079: Create rc_ip_bin column and index for recentchanges table

ALTER TABLE /*$wgDBPrefix*/recentchanges
  ADD rc_ip_bin VARBINARY(16) NOT NULL DEFAULT '';

CREATE INDEX /*i*/rc_ip_bin ON /*_*/recentchanges (rc_ip_bin, rc_timestamp);
