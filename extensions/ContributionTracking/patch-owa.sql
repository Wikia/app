--
-- create contribution_tracking.owa_session and owa_ref
--
ALTER TABLE /*_*/contribution_tracking ADD owa_session varbinary(255) default NULL;
ALTER TABLE /*_*/contribution_tracking ADD owa_ref int(11) default NULL;
