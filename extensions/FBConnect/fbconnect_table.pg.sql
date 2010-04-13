
-- Schema for the FBConnect extension (Postgres version)

CREATE TABLE user_fbconnect (
  user_fbid BIGINT NOT NULL PRIMARY KEY,
  user_id   INTEGER NOT NULL REFERENCES mwuser(user_id)
);

CREATE INDEX user_fbconnect_user ON user_fbconnect(user_id);
