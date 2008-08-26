-- SQL tables for AbuseFilter extension (Postgres version)

BEGIN;

CREATE SEQUENCE abuse_filter_af_id_seq;
CREATE TABLE abuse_filter (
    af_id               INTEGER      NOT NULL PRIMARY KEY DEFAULT nextval('abuse_filter_af_id_seq'),
    af_pattern          TEXT         NOT NULL,
    af_user             INTEGER      NOT NULL,
    af_user_text        TEXT         NOT NULL,
    af_timestamp        TIMESTAMPTZ  NOT NULL,
    af_enabled          SMALLINT     NOT NULL             DEFAULT 1,
    af_comments         TEXT,
    af_public_comments  TEXT,
    af_hidden           SMALLINT     NOT NULL             DEFAULT 0,
    af_hit_count        INTEGER      NOT NULL             DEFAULT 0,
    af_throttled        SMALLINT     NOT NULL             DEFAULT 0
);
CREATE INDEX abuse_filter_user ON abuse_filter(af_user);


CREATE TABLE abuse_filter_action (
    afa_filter       INTEGER  NOT NULL,
    afa_consequence  TEXT     NOT NULL,
    afa_parameters   TEXT     NOT NULL,
    PRIMARY KEY (afa_filter,afa_consequence)
);
CREATE INDEX abuse_filter_action_consequence ON abuse_filter_action(afa_consequence);


CREATE SEQUENCE abuse_filter_log_afl_id_seq;
CREATE TABLE abuse_filter_log (
    afl_id         INTEGER      NOT NULL PRIMARY KEY DEFAULT nextval('abuse_filter_log_afl_id_seq'),
    afl_filter     INTEGER      NOT NULL,
    afl_user       INTEGER      NOT NULL,
    afl_user_text  TEXT         NOT NULL,
    afl_ip         TEXT         NOT NULL,
    afl_action     TEXT         NOT NULL,
    afl_actions    TEXT         NOT NULL,
    afl_var_dump   TEXT         NOT NULL,
    afl_timestamp  TIMESTAMPTZ  NOT NULL,
    afl_namespace  SMALLINT     NOT NULL,
    afl_title      TEXT         NOT NULL
);
CREATE INDEX abuse_filter_id        ON abuse_filter_log(afl_filter);
CREATE INDEX abuse_filter_log_user  ON abuse_filter_log(afl_user_text);
CREATE INDEX abuse_filter_log_title ON abuse_filter_log(afl_title);


COMMIT;

