-- Add expiration column index

ALTER TABLE /*$wgDBprefix*/flaggedpage_config 
  ADD INDEX (fpc_expiry);
