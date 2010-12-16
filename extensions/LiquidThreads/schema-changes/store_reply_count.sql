ALTER TABLE /*_*/thread ADD COLUMN thread_replies int(8) NOT NULL DEFAULT -1;
UPDATE /*_*/thread SET thread_replies = -1;
