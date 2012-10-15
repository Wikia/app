-- Postgres version

CREATE TABLE user_board (
  ub_id             SERIAL       PRIMARY KEY,
  ub_user_id        INTEGER      NOT NULL  DEFAULT 0,
  ub_user_name      TEXT         NOT NULL  DEFAULT '',
  ub_user_id_from   INTEGER      NOT NULL  DEFAULT 0,
  ub_user_name_from TEXT         NOT NULL  DEFAULT '',
  ub_message        TEXT         NOT NULL,
  ub_type           INTEGER                DEFAULT 0,
  ub_date           TIMESTAMPTZ  NOT NULL  DEFAULT now()
);
CREATE INDEX social_profile_ub_user_id ON user_board(ub_user_id);
CREATE INDEX social_profile_ub_user_id_from ON user_board(ub_user_id_from);
CREATE INDEX social_profile_ub_type ON user_board(ub_type);
