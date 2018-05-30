create table article_comments (
	comment_id int(8) unsigned not null,
	article_id int(8) unsigned not null,
	parent_comment_id int(8) unsigned not null default 0,
	PRIMARY KEY (comment_id),
	KEY article_comments_idx (article_id, parent_comment_id),
	FOREIGN KEY comment_page (comment_id) REFERENCES page (page_id) ON DELETE CASCADE,
	FOREIGN KEY article_page (article_id) REFERENCES page (page_id) ON DELETE CASCADE
) ENGINE=InnoDB;