-- Update to allow for any number of projects per campaign.

CREATE TABLE IF NOT EXISTS /*$wgDBprefix*/cn_notice_projects (
	`np_notice_id` int unsigned NOT NULL,
	`np_project` varchar(32) NOT NULL
) /*$wgDBTableOptions*/;
CREATE UNIQUE INDEX /*i*/np_notice_id_project ON /*$wgDBprefix*/cn_notice_projects (np_notice_id, np_project);
