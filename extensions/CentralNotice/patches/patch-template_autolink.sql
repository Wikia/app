-- Update to add a separate flag for automatic link creation

-- Store a flag indicating whether or not this banner uses automatic link creation
ALTER TABLE /*$wgDBprefix*/cn_templates ADD `tmp_autolink` bool NOT NULL DEFAULT 0 AFTER `tmp_fundraising`;

-- Store before and after flag values for logging
ALTER TABLE /*$wgDBprefix*/cn_template_log ADD `tmplog_begin_autolink` bool NULL DEFAULT NULL AFTER `tmplog_end_fundraising`;
ALTER TABLE /*$wgDBprefix*/cn_template_log ADD `tmplog_end_autolink` bool NULL DEFAULT NULL AFTER `tmplog_begin_autolink`;

-- Add an index for banner names since we sometimes use them for selection
CREATE INDEX /*i*/tmp_name ON /*$wgDBprefix*/cn_templates (tmp_name);
