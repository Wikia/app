-- Add expiration column index

CREATE INDEX fpc_expiry ON flaggedpage_config (fpc_expiry);
