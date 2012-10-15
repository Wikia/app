--- Adds an af_actions field to the abuse_filter table, so we don't need to LEFT JOIN on abuse_filter_action and use a GROUP_CONCAT, which isn't compatible with mysql 4.0
--- Andrew Garrett, 2009-01-27

ALTER TABLE /*_*/abuse_filter add column af_actions varchar(255) NOT NULL DEFAULT '';
