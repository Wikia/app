-- Postgres version

CREATE TABLE user_system_gift (
  sg_id        SERIAL       PRIMARY KEY,
  sg_gift_id   INTEGER      NOT NULL  DEFAULT 0,
  sg_user_id   INTEGER      NOT NULL  DEFAULT 0,
  sg_user_name TEXT         NOT NULL  DEFAULT '',
  sg_status    INTEGER                DEFAULT 1,
  sg_date      TIMESTAMPTZ  NOT NULL  DEFAULT now()
);
CREATE INDEX social_profile_usg_gift_id ON user_system_gift(sg_gift_id);
CREATE INDEX social_profile_usg_user_id ON user_system_gift(sg_user_id);

CREATE TABLE system_gift (
  gift_id           SERIAL       PRIMARY KEY,
  gift_name         TEXT         NOT NULL  DEFAULT '',
  gift_description  TEXT,
  gift_given_count  INTEGER                DEFAULT 0,
  gift_category     INTEGER                DEFAULT 0,
  gift_threshold    INTEGER                DEFAULT 0,
  gift_createdate   TIMESTAMPTZ  NOT NULL  DEFAULT now()
);
CREATE INDEX social_profile_sg_category ON system_gift(gift_category);
CREATE INDEX social_profile_sg_threshold ON system_gift(gift_threshold);
