
BEGIN;

CREATE SEQUENCE cu_log_cul_id_seq;
CREATE TABLE cu_log (
  cul_id           INTEGER  NOT NULL DEFAULT nextval('cu_log_cul_id_seq'),
  cul_timestamp    TIMESTAMPTZ,
  cul_user         INTEGER      NULL REFERENCES mwuser(user_id) ON DELETE SET NULL,
  cul_user_text    TEXT     NOT NULL,
  cul_reason       TEXT     NOT NULL DEFAULT '',
  cul_type         TEXT     NOT NULL DEFAULT '',
  cul_target_id    INTEGER      NULL REFERENCES mwuser(user_id) ON DELETE SET NULL,
  cul_target_text  TEXT     NOT NULL DEFAULT '',
  cul_target_hex   TEXT     NOT NULL DEFAULT '',
  cul_range_start  TEXT     NOT NULL DEFAULT '',
  cul_range_end    TEXT     NOT NULL DEFAULT ''
);

CREATE INDEX cul_timestamp ON cu_log (cul_timestamp);
CREATE INDEX cul_user ON cu_log (cul_user);
CREATE INDEX cul_type_target ON cu_log (cul_type,cul_target_id);
CREATE INDEX cul_target_hex ON cu_log (cul_target_hex);
CREATE INDEX cul_range_start ON cu_log (cul_range_start);

COMMIT;
