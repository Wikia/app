
-- Schema for the OpenID extension (Postgres version)

CREATE TABLE user_openid (
  uoi_openid  VARCHAR(255) PRIMARY KEY NOT NULL,
  uoi_user    INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX user_openid_unique ON user_openid(uoi_user);
