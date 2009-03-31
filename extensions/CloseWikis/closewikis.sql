-- Tables for CloseWikis extension

CREATE TABLE /*$wgDBprefix*/closedwikis (
	cw_wiki varchar(255) NOT NULL,
	cw_reason mediumblob NOT NULL,
	cw_timestamp binary(14) NOT NULL,
	cw_by tinyblob NOT NULL,

	UNIQUE INDEX cw_wiki (cw_wiki)
) /*$wgDBTableOptions*/;
