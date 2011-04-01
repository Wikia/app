CREATE TABLE user_interview_questions (
	id int primary key auto_increment not null,
	wiki_id int,
	question mediumblob,
	date_set timestamp default current_timestamp,
	KEY(wiki_id)
);

CREATE TABLE user_interview_answers (
	id int primary key auto_increment not null,
	wiki_id int,
	question_id int,
	user_id int,
	question blob,
	answer blob,
	date_set timestamp default current_timestamp,
	KEY(user_id)
);