-- Schema change 5 — adds and populates 'editedness' field
--  for performantly determining if a thread has been edited.

alter table /*_*/thread add column thread_editedness int(1) NOT NULL default 0;

update /*_*/thread join /*_*/thread as child on child.thread_parent = /*_*/thread.thread_id
	set thread.thread_editedness = 1;

create temporary table /*_*/counts (
	thread_id int(8) unsigned,
	revision_count int(8) unsigned,
	author_count int(8) unsigned,
	rev_user int(8) unsigned
);

insert into /*_*/counts (thread_id, revision_count, author_count, rev_user)
	select thread_id, count(thread_id), count(distinct rev_user), rev_user
		from /*_*/thread join /*_*/revision on rev_page = thread_root
		group by thread_id;

update /*_*/thread join /*_*/counts on /*_*/thread.thread_id = /*_*/counts.thread_id
	set thread_editedness = 2
	where revision_count > 1;

update /*_*/thread join counts on /*_*/thread.thread_id = /*_*/counts.thread_id
	set thread_editedness = 3
	where author_count > 1 or (rev_user = 0 and revision_count > 1);

drop table /*_*/counts;
