-- Schema change 1 — replaces thread_article with thread_article_namespace/title tuple

update /*_*/thread, /*_*/page
	set thread_article_title=page_title,
		thread_article_namespace=page_namespace
	where page_id=thread_article and
			thread_article is not null and
			thread_article != 0;

alter table /*_*/thread drop column thread_article;
alter table /*_*/thread modify thread_article_namespace not null;
alter table /*_*/thread modify thread_article_title varchar(255) binary not null;
