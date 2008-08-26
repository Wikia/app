alter table thread change thread_timestamp thread_modified char(14) binary NOT NULL default '';
alter table thread add column thread_created char(14) binary NOT NULL default '';
update thread set thread_created = thread_modified;
alter table thread add index thread_created (thread_created);
