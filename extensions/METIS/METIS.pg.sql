
-- Schema for the METIS extension, Postgres version.

CREATE SEQUENCE metis_metis_id_seq;

CREATE TABLE metis (
  metis_id      INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('metis_metis_id_seq'),
  metis_pixel   VARCHAR(80) NOT NULL,
  metis_author  VARCHAR(80)     NULL
);
