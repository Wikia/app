-- add object_ids to the collection contents table (it should have had them before already, c'est la vie)
-- If you are writing generic code, just beware of the fact that an object_id can be null for legacy data,
-- or for data inserted by legacy code.
-- (In future, a nice plan might be to fix legacy code and retroactively assign object id's. )

ALTER TABLE /*$wdPrefix*/collection_contents add column object_id int(11) first;

INSERT INTO `script_log` (`time`, `script_name`, `comment`) VALUES (NOW(), '36 Table changes for copying B.sql', "added an object_id column to /*$wdPrefix*/collection_contents");
