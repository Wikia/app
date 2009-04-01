CREATE TABLE text_regex (
	tr_id int(8) NOT NULL AUTO_INCREMENT,
	tr_text varchar(255) NOT NULL,
	tr_timestamp char(14) NOT NULL,
	tr_user int(8) NOT NULL,
	tr_subpage varchar(255) NOT NULL,
	PRIMARY KEY ( tr_id ),
	UNIQUE KEY tr_text_subpage ( tr_text, tr_subpage ),
	KEY tr_subpage (tr_subpage),
	KEY tr_timestamp ( tr_timestamp ),
	KEY tr_user ( tr_user )
) ENGINE=InnoDB;

CREATE TABLE text_regex_stats (
	trs_id int(5) NOT NULL AUTO_INCREMENT,
	trs_tr_id int(8) NOT NULL,
	trs_timestamp char(14) NOT NULL,
	trs_user varchar(255) NOT NULL,
	trs_text text NOT NULL,
	trs_comment text NOT NULL,
	PRIMARY KEY ( trs_id ),
	KEY trs_tr_id ( trs_tr_id ),
	KEY trs_timestamp ( trs_timestamp ),
	KEY trs_user ( trs_user )
) ENGINE=InnoDB;
