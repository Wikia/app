-- Schema change 3 — replaces thread_path field with a tuple of ancestor/parent for
--  more normalised reply tracking.

alter table /*_*/thread add column thread_ancestor int(8) unsigned not null;
alter table /*_*/thread add column thread_parent int(8) unsigned null;
alter table /*_*/thread add index thread_ancestor (thread_ancestor);

update /*_*/thread set thread_ancestor = substring_index(thread_path, ".", 1),
	thread_parent = substring_index(substring_index(thread_path, ".", -2), ".", 1 )
where locate(".", thread_path) != 0;

update /*_*/thread set thread_ancestor = substring_index(thread_path, ".", 1),
	thread_parent = null
where locate(".", thread_path) = 0;

alter table /*_*/thread drop column thread_path;
