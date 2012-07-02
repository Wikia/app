-- Update to allow for any number of geotargetted countries per notice.

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_notice_countries (
	nc_notice_id int unsigned NOT NULL,
	nc_country varchar(2) NOT NULL
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/nc_notice_id_country ON /*$wgDBprefix*/cn_notice_countries (nc_notice_id, nc_country);
ALTER TABLE /*$wgDBprefix*/cn_notices ADD not_geo bool NOT NULL DEFAULT '0' AFTER not_locked;
