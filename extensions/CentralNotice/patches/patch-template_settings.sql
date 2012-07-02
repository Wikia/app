-- Update to support controlling whether banners are displayed to anon and/or logged in users. 
-- Two flags are stored in the database for each banner, one indicating whether or not the banner
-- is displayed to anonymous users, the other indicating whether or not the banner is displayed
-- to logged in users.

ALTER TABLE /*$wgDBprefix*/cn_templates ADD `tmp_display_anon` bool NOT NULL DEFAULT 1;
ALTER TABLE /*$wgDBprefix*/cn_templates ADD `tmp_display_account` bool NOT NULL DEFAULT 1;
