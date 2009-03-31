-- Postgres schema for the Oversight extension
-- See the 'hidden.sql' file for explanations of the columns

BEGIN;

CREATE TABLE hidden (
  hidden_page         INTEGER      NOT NULL  DEFAULT 0,
  hidden_namespace    INTEGER      NOT NULL  DEFAULT 0,
  hidden_title        TEXT         NOT NULL  DEFAULT '',
  hidden_comment      TEXT         NOT NULL,
  hidden_user         INTEGER      NOT NULL  DEFAULT 0,
  hidden_user_text    TEXT         NOT NULL,
  hidden_timestamp    TIMESTAMPTZ  NOT NULL  DEFAULT NOW(),
  hidden_minor_edit   SMALLINT     NOT NULL  DEFAULT 0,
  hidden_deleted      SMALLINT     NOT NULL  DEFAULT 0,
  hidden_rev_id       INTEGER,
  hidden_text_id      INTEGER,
  hidden_by_user      INTEGER,
  hidden_on_timestamp TIMESTAMPTZ,
  hidden_reason       TEXT
);

CREATE INDEX hidden_timestamp    ON hidden(hidden_timestamp);
CREATE INDEX hidden_on_timestamp ON hidden(hidden_on_timestamp);
CREATE INDEX hidden_user         ON hidden(hidden_by_user);
CREATE INDEX hidden_page         ON hidden(hidden_page);
CREATE INDEX hidden_title        ON hidden(hidden_title);

COMMIT;
