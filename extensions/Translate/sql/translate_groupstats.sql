CREATE TABLE /*_*/translate_groupstats (
	tgs_group varchar(100) binary NOT NULL,
	tgs_lang varchar(20) binary NOT NULL,
	tgs_total int(5) unsigned,
	tgs_translated int(5) unsigned,
	tgs_fuzzy int(5) unsigned,
	PRIMARY KEY (tgs_group, tgs_lang)
) /*$wgDBTableOptions*/;