-- Postgres version of the database schema for the Storyboard extension.
-- TODO: update to equivalent of latest MySQL sql

BEGIN;

CREATE SEQUENCE story_id_seq;

CREATE TABLE `storyboard` (
  story_id           INTEGER       PRIMARY KEY DEFAULT nextval('story_id_seq'),
  story_author_id    INTEGER           NULL,
  story_author_name  TEXT              NULL, 
  story_hit_count    INTEGER       NOT NULL,
  story_title        TEXT          NOT NULL,
  story_text         TEXT              NULL,
  story_modified     TIMESTAMPTZ       NULL DEFAULT now(),
  story_created      TIMESTAMPTZ       NULL DEFAULT now(),
); 

COMMIT;