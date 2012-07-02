
BEGIN;

CREATE TABLE flaggedrevs_promote (
  frp_user_id INTEGER NOT NULL PRIMARY KEY default 0,
  frp_user_params TEXT NOT NULL default ''
);

COMMIT;