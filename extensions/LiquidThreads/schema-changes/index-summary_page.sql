-- Schema change 6, adds thread_summary_page index.

alter table /*_*/thread add index thread_summary_page (thread_summary_page);
