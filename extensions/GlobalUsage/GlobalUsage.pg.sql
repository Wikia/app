CREATE TABLE globalimagelinks (
	gil_wiki           TEXT     NOT NULL,
	gil_page           INTEGER  NOT NULL,
	gil_page_namespace_id INTEGER NOT NULL,
	gil_page_namespace TEXT     NOT NULL,
	gil_page_title     TEXT     NOT NULL,
	gil_to             TEXT     NOT NULL,
	PRIMARY KEY (gil_to, gil_wiki, gil_page)
);
CREATE INDEX globalimagelinks_wiki ON globalimagelinks(gil_wiki, gil_page);

