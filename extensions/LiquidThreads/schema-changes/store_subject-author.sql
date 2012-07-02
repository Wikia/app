-- Schema change 7 — add thread subject to the thread table.

ALTER TABLE /*_*/thread add column thread_subject varchar(255) NULL;
ALTER TABLE /*_*/thread add column thread_author_id int unsigned NULL;
ALTER TABLE /*_*/thread add column thread_author_name varchar(255) NULL;
