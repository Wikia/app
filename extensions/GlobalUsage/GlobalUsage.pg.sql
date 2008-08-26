CREATE TABLE globalimagelinks (
	gil_wiki           TEXT     NOT NULL,
	gil_page           INTEGER  NOT NULL,
	gil_page_namespace TEXT     NOT NULL,
	gil_page_title     TEXT     NOT NULL,
	gil_to             TEXT     NOT NULL,
	gil_is_local       SMALLINT NOT NULL,
	PRIMARY KEY (gil_wiki, gil_page)
);
CREATE INDEX globalimagelinks_wiki ON globalimagelinks(gil_wiki, gil_to);
CREATE INDEX globalimagelinks_to ON globalimagelinks(gil_to, gil_is_local);
