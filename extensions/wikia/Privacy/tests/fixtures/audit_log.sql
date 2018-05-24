DROP TABLE IF EXISTS rtbf_log;
CREATE TABLE rtbf_log (
  id int PRIMARY KEY AUTOINCREMENT,
	user_id int(5) NOT NULL,
	created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	number_of_wikis int
);

DROP TABLE IF EXISTS rtbf_log_details;
CREATE TABLE rtbf_log_details (
  log_id int NOT NULL,
	wiki_id int NOT NULL,
	created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	celery_task char(39),
	finished datetime,
	was_successful bool,
	foreign key (log_id) references rtbf_log(id),
	unique (log_id, wiki_id)
);