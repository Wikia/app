-- Add expiration column

ALTER TABLE /*$wgDBprefix*/flaggedpage_config 
  ADD fpc_expiry varbinary(14) NOT NULL default 'infinity';
