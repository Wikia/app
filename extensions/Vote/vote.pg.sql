
-- Table for the Vote extension; holds individual votes (Postgres version)

BEGIN;

CREATE SEQUENCE vote_vote_id_seq;

CREATE TABLE vote (
  vote_id      INTEGER PRIMARY KEY NOT NULL DEFAULT nextval('vote_vote_id_seq'),
  vote_user    INTEGER             NOT NULL,
  vote_choice  VARCHAR(255)        NOT NULL
);

CREATE INDEX vote_choice_index ON vote(vote_choice);

COMMIT;
