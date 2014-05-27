-- Adds gu_authtoken column.
-- Used for storing a random authentication token for authenticating crosswiki.
-- Andrew Garrett (werdna), April 2008.
ALTER TABLE globaluser ADD COLUMN gu_auth_token varbinary(32) NULL;
