
BEGIN;

CREATE TABLE editings (
  editings_page    INTEGER   NOT NULL,
  editings_user    TEXT      NOT NULL,
  editings_started TIMESTAMP NOT NULL,
  editings_touched TIMESTAMP NOT NULL
);

ALTER TABLE editings ADD CONSTRAINT editings_pk
  PRIMARY KEY (editings_page,editings_user);

CREATE INDEX editings_page_started_key ON editings (editings_started);
COMMIT;
