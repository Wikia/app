SET foreign_key_checks = 0;

CREATE TABLE IF NOT EXISTS rtbf_log (
  id int PRIMARY KEY AUTO_INCREMENT,
	user_id int(5) NOT NULL,
	created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	number_of_wikis int,
	global_data_removed bool
);

CREATE TABLE IF NOT EXISTS rtbf_log_details (
  log_id int NOT NULL,
	wiki_id int NOT NULL,
	created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	celery_task char(39),
	finished datetime,
	was_successful bool,
	foreign key (log_id) references rtbf_log(id),
	unique key (log_id, wiki_id)
);
SET foreign_key_checks = 1;
