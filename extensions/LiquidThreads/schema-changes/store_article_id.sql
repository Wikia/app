-- Add the thread_article_id field. Populated on-demand in Thread.php
ALTER TABLE /*_*/thread ADD COLUMN thread_article_id int(8) unsigned NOT NULL;
ALTER TABLE /*_*/thread ADD INDEX thread_article (thread_article_id, thread_sortkey);
