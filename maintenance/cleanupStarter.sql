-- Remove page entries for all files since they belong to shared db.
delete from page where page_namespace=6;
delete from revision where rev_id not in (select page_latest from page);
delete from text where old_id not in (select rev_text_id from revision);
