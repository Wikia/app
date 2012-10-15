
-- Schema for the OpenID extension (Postgres version)

CREATE TABLE /*_*/user_openid (
  uoi_openid VARCHAR(255) NOT NULL PRIMARY KEY,
  uoi_user   INTEGER NOT NULL REFERENCES mwuser(user_id)
);

CREATE INDEX /*i*/user_openid_user ON /*_*/user_openid(uoi_user);
