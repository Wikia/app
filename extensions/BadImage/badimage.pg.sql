-- Postgres version
CREATE TABLE bad_images (
  bil_name      TEXT        NOT NULL,
  bil_timestamp TIMESTAMPTZ NOT NULL,
  bil_user      INTEGER     NOT NULL,
  bil_reason    TEXT        NOT NULL
);

CREATE UNIQUE INDEX bil_name_unique ON bad_images (bil_name);

