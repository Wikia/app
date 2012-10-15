-- MediaWiki Wikilog extension database patch.
--
-- Version: 1.0.99.1dev
-- Add wlc_timestamp and wlc_updated indexes to wikilog_comments table.
--

ALTER TABLE /*$wgDBprefix*/wikilog_comments
  ADD INDEX wlc_timestamp (wlc_timestamp),
  ADD INDEX wlc_updated (wlc_updated);
