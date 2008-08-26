alter table thread add column thread_ancestor int(8) unsigned not null;
alter table thread add column thread_parent int(8) unsigned null;
alter table thread add index thread_ancestor (thread_ancestor);

update thread set thread_ancestor = substring_index(thread_path, ".", 1),
	thread_parent = substring_index(substring_index(thread_path, ".", -2), ".", 1 )
where locate(".", thread_path) != 0;

update thread set thread_ancestor = substring_index(thread_path, ".", 1),
	thread_parent = null
where locate(".", thread_path) = 0;

alter table thread drop column thread_path;
