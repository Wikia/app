-- Postgres version

CREATE TABLE user_gift (
  ug_id              SERIAL       PRIMARY KEY,
  ug_gift_id         INTEGER      NOT NULL  DEFAULT 0,
  ug_user_id_to      INTEGER      NOT NULL  DEFAULT 0,
  ug_user_name_to    TEXT         NOT NULL  DEFAULT '',
  ug_user_id_from    INTEGER      NOT NULL  DEFAULT 0,
  ug_user_name_from  TEXT         NOT NULL  DEFAULT '',
  ug_status          INTEGER                DEFAULT 1,
  ug_type            INTEGER,
  ug_message         TEXT,
  ug_date            TIMESTAMPTZ  NOT NULL  DEFAULT now()
);
CREATE INDEX social_profile_ug_user_id_from ON user_gift(ug_user_id_from);
CREATE INDEX social_profile_ug_user_id_to ON user_gift(ug_user_id_to);

CREATE TABLE gift (
  gift_id                 SERIAL       PRIMARY KEY,
  gift_access             INTEGER      NOT NULL  DEFAULT 0,
  gift_creator_user_id    INTEGER      NOT NULL  DEFAULT 0,
  gift_creator_user_name  TEXT         NOT NULL  DEFAULT '',
  gift_name               TEXT         NOT NULL  DEFAULT '',
  gift_description        TEXT,
  gift_given_count        INTEGER                DEFAULT 0,
  gift_createdate         TIMESTAMPTZ  NOT NULL  DEFAULT now()
);
