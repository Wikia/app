-- Schema change 4 — Replaces thread_timestamp with thread_modified and thread_created
--  Also adds a thread_created index.

alter table /*_*/thread change thread_timestamp thread_modified char(14) binary NOT NULL default '';
alter table /*_*/thread add column thread_created char(14) binary NOT NULL default '';
update /*_*/thread set thread_created = thread_modified where thread_created='';
alter /*_*/table thread add index /*i*/thread_created (thread_created);
