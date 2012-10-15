-- Patch to add abuse_filter_history table (Postgres version)

BEGIN;


CREATE SEQUENCE abuse_filter_history_afh_id_seq;
CREATE TABLE abuse_filter_history (
    afh_id               INTEGER      NOT NULL PRIMARY KEY DEFAULT nextval('abuse_filter_history_afh_id_seq'),
    afh_filter           INTEGER      NOT NULL,
    afh_user             INTEGER      NOT NULL,
    afh_user_text        TEXT         NOT NULL,
    afh_timestamp        TIMESTAMPTZ  NOT NULL,
    afh_pattern          TEXT         NOT NULL,
    afh_comments         TEXT         NOT NULL,
    afh_flags            TEXT         NOT NULL,
    afh_public_comments  TEXT         NOT NULL,
    afh_actions          TEXT         NOT NULL,
    afh_deleted          SMALLINT     NOT NULL             DEFAULT 0,
    afh_changed_fields   TEXT         NOT NULL             DEFAULT ''
);
CREATE INDEX abuse_filter_history_filter    ON abuse_filter_history(afh_filter);
CREATE INDEX abuse_filter_history_user      ON abuse_filter_history(afh_user);
CREATE INDEX abuse_filter_history_user_text ON abuse_filter_history(afh_user_text);
CREATE INDEX abuse_filter_history_timestamp ON abuse_filter_history(afh_timestamp);


COMMIT;


