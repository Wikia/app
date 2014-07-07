BEGIN;

CREATE TABLE flaggedpage_pending (
  fpp_page_id BIGINT NOT NULL,
  fpp_quality INTEGER NOT NULL,
  fpp_rev_id  BIGINT NOT NULL,
  fpp_pending_since TIMESTAMPTZ NULL,
  PRIMARY KEY (fpp_page_id,fpp_quality)
);
CREATE INDEX fpp_quality_pending ON flaggedpage_pending (fpp_quality,fpp_pending_since);

COMMIT;
