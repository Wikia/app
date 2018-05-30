create table article_comments (
	comment_id int not null,
	article_id int not null,
	parent_comment_id int not null default 0,
	PRIMARY KEY (comment_id),
	KEY article_comments_idx (article_id, parent_comment_id)
) ENGINE=InnoDB;