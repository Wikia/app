
BEGIN;

CREATE TABLE reader_feedback (
  rfb_rev_id   INTEGER   NOT NULL DEFAULT 0,
  rfb_user     INTEGER   NULL REFERENCES mwuser(user_id) ON DELETE SET NULL,
  rfb_ip       TEXT       NOT NULL DEFAULT '',
  PRIMARY KEY (rfb_rev_id,rfb_user,rfb_ip)
);

CREATE TABLE reader_feedback_history (
  rfh_page_id  INTEGER   NOT NULL DEFAULT 0,
  rfh_tag      TEXT       NOT NULL DEFAULT '',
  rfh_total    INTEGER   NOT NULL DEFAULT 0,
  rfh_count    INTEGER   NOT NULL DEFAULT 0,
  -- MW date of the day this average corresponds to
  rfh_date     TEXT       NOT NULL DEFAULT '',
  PRIMARY KEY (rfh_page_id,rfh_tag,rfh_date)
);

CREATE TABLE reader_feedback_pages (
  rfp_page_id  INTEGER     NOT NULL DEFAULT 0,
  rfp_tag      TEXT         NOT NULL DEFAULT '',
  rfp_ave_val  REAL         NOT NULL DEFAULT 0,
  rfp_count    INTEGER     NOT NULL DEFAULT 0,
  rfp_touched  TIMESTAMPTZ  NULL,
  PRIMARY KEY (rfp_page_id,rfp_tag)
);
CREATE INDEX rfp_tag_val_page ON reader_feedback_pages (rfp_tag,rfp_ave_val,rfp_page_id)

COMMIT;