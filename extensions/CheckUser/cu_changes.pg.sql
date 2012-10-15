-- Tables for the CheckUser extension
-- vim: autoindent syn=pgsql sts=2 sw=2
-- This is the Postgres version
-- See cu_changes.sql for details on each column

BEGIN;

CREATE SEQUENCE cu_changes_cu_id_seq;
CREATE TABLE cu_changes (
  cuc_id         INTEGER  NOT NULL DEFAULT nextval('cu_changes_cu_id_seq'),
  cuc_namespace  SMALLINT NOT NULL DEFAULT 0,
  cuc_title      TEXT     NOT NULL DEFAULT '',
  cuc_user       INTEGER      NULL REFERENCES mwuser(user_id) ON DELETE SET NULL,
  cuc_user_text  TEXT     NOT NULL,
  cuc_actiontext TEXT     NOT NULL DEFAULT '',
  cuc_comment    TEXT     NOT NULL DEFAULT '',
  cuc_minor      CHAR     NOT NULL DEFAULT 0,
  cuc_page_id    INTEGER      NULL REFERENCES page(page_id) ON DELETE SET NULL,
  cuc_this_oldid INTEGER  NOT NULL DEFAULT 0,
  cuc_last_oldid INTEGER  NOT NULL DEFAULT 0,
  cuc_type       SMALLINT NOT NULL DEFAULT 0,
  cuc_timestamp  TIMESTAMPTZ,
  cuc_ip         CIDR,
  cuc_ip_hex     TEXT,
  cuc_xff        TEXT,
  cuc_xff_hex    TEXT,
  cuc_agent      TEXT
);

CREATE INDEX cuc_ip_hex_time  ON cu_changes( cuc_ip_hex, cuc_timestamp );
CREATE INDEX cuc_user_ip_time ON cu_changes( cuc_user, cuc_ip, cuc_timestamp );
CREATE INDEX cuc_xff_hex_time ON cu_changes( cuc_xff_hex, cuc_timestamp );

COMMIT;
