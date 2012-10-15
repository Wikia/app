-- This stores user rating data for revisions
-- Postgres version

CREATE SEQUENCE validate_id_seq;

CREATE TABLE validate (
  val_id        INTEGER  NOT NULL DEFAULT nextval('validate_id_seq'),
  val_user      INTEGER  NOT NULL,
  val_page      INTEGER  NOT NULL,
  val_revision  INTEGER  NOT NULL,
  val_type      SMALLINT NOT NULL DEFAULT 1,
  val_value     SMALLINT NOT NULL,
  val_comment   TEXT     NOT NULL DEFAULT '',
  val_ip        TEXT     NULL,
  PRIMARY KEY (val_id)
);

CREATE INDEX validate_index ON validate(val_user,val_revision,val_type);
