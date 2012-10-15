CREATE TABLE /*$wgDBprefix*/spam_regex (
	spam_id int(5) NOT NULL AUTO_INCREMENT,
	spam_text varchar(255) NOT NULL,
	spam_timestamp char(14) NOT NULL,
	spam_user varchar(255) NOT NULL,
	spam_textbox int(1) NOT NULL DEFAULT 1,
	spam_summary int(1) NOT NULL DEFAULT 0,
	PRIMARY KEY( spam_id ),
	UNIQUE KEY spam_text( spam_text ),
	KEY spam_timestamp ( spam_timestamp ),
	KEY spam_user ( spam_user )
) /*$wgDBTableOptions*/;