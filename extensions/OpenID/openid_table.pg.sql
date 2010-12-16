
-- Schema for the OpenID extension (Postgres version)

CREATE TABLE user_openid (
  uoi_openid VARCHAR(255) NOT NULL PRIMARY KEY,
  uoi_user   INTEGER NOT NULL REFERENCES mwuser(user_id)
);

CREATE INDEX user_openid_user ON user_openid(uoi_user);
