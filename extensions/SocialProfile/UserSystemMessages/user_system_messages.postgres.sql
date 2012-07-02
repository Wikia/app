-- Postgres version

CREATE TABLE user_system_messages (
  um_id         SERIAL       PRIMARY KEY,
  um_user_id    INTEGER      NOT NULL  DEFAULT 0,
  um_user_name  TEXT         NOT NULL  DEFAULT '',
  um_message    TEXT         NOT NULL  DEFAULT '',
  um_type       INTEGER                DEFAULT 0,
  um_date       TIMESTAMPTZ  NOT NULL  DEFAULT now()
);
CREATE INDEX social_profile_usm_user_id ON user_system_messages(um_user_id);
