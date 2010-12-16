
-- Schema for the ContributionTracking extension
-- Postgres version

BEGIN;

CREATE TABLE contribution_tracking (
  id              SERIAL PRIMARY KEY,
  contribution_id INTEGER,
  note            TEXT,
  referrer        TEXT,
  anonymous       SMALLINT,
  utm_source      TEXT,
  utm_medium      TEXT,
  utm_campaign    TEXT,
  optout          SMALLINT,
  language        TEXT,
  ts              TIMESTAMPTZ
);

CREATE UNIQUE INDEX contribution_tracking_index1 ON contribution_tracking(contribution_id);
CREATE UNIQUE INDEX contribution_tracking_index2 ON contribution_tracking(ts);

COMMIT;

