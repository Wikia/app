-- Update to support fundraiser-specific functions for banners

-- Store a flag indicating whether or not this is a fundraising banner
ALTER TABLE /*$wgDBprefix*/cn_templates ADD `tmp_fundraising` bool NOT NULL DEFAULT 0;
-- Store a list of one or more landing pages
ALTER TABLE /*$wgDBprefix*/cn_templates ADD `tmp_landing_pages` VARCHAR( 255 ) NULL DEFAULT NULL;