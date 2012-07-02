-- Add and populate the thread_sortkey field
ALTER TABLE /*_*/thread ADD COLUMN thread_sortkey varchar(255) NOT NULL default '';
ALTER TABLE /*_*/thread ADD INDEX thread_sortkey (thread_sortkey);

UPDATE /*_*/thread SET thread_sortkey=thread_modified;
