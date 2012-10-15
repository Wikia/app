-- Captured email addresses
CREATE TABLE IF NOT EXISTS /*_*/email_capture (
  -- Email address
  ec_email varbinary(255) PRIMARY KEY NOT NULL DEFAULT '',
  -- Additional information
  ec_info blob NOT NULL DEFAULT '',
  -- Verification code
  ec_code varbinary(32) NOT NULL DEFAULT '',
  -- Verified
  ec_verified boolean DEFAULT 0
) /*$wgDBTableOptions*/;
CREATE INDEX /*i*/ec_code_verified ON /*_*/email_capture (ec_code, ec_verified);
