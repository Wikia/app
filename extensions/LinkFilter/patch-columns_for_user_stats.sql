-- This patch adds two columns to user_stats table which are required by LinkFilter extension
-- Tracks submitted links
ALTER TABLE /*$wgDBprefix*/user_stats ADD COLUMN `stats_links_submitted` int(11) NOT NULL default '0';
-- Tracks all approved links that have been submitted by the user
ALTER TABLE /*$wgDBprefix*/user_stats ADD COLUMN `stats_links_approved` int(11) NOT NULL default '0';