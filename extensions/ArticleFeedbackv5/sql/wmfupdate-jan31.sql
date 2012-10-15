CREATE TABLE IF NOT EXISTS /*_*/aft_article_filter_count (
  afc_page_id      integer unsigned NOT NULL,
  afc_filter_name  varchar(64) NOT NULL,
  afc_filter_count integer unsigned NOT NULL,
  PRIMARY KEY (afc_page_id, afc_filter_name)
);

ALTER TABLE /*_*/aft_article_feedback
	ADD COLUMN af_abuse_count integer unsigned NOT NULL DEFAULT 0,
	ADD COLUMN af_helpful_count   integer unsigned NOT NULL DEFAULT 0,
	ADD COLUMN af_unhelpful_count integer unsigned NOT NULL DEFAULT 0,
	ADD COLUMN af_needs_oversight boolean NOT NULL DEFAULT FALSE,
	ADD COLUMN af_is_deleted      boolean NOT NULL DEFAULT FALSE,
	ADD COLUMN af_is_hidden       boolean NOT NULL DEFAULT FALSE,
	ADD COLUMN af_net_helpfulness integer NOT NULL DEFAULT 0;

CREATE INDEX /*i*/afo_field_id ON /*_*/aft_article_field_option (afo_field_id);
CREATE INDEX /*i*/af_net_helpfulness ON /*_*/aft_article_feedback (af_net_helpfulness);

