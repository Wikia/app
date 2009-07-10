--- 2009-01-26, Andrew Garrett
--- Adds a 'changed fields' field to the abuse filter history, so that we can highlight fields which changed!
ALTER TABLE /*_*/abuse_filter_history add column afh_changed_fields varchar(255) NOT NULL DEFAULT '';
