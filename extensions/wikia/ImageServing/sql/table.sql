CREATE TABLE /*$wgDBprefix*/page_wikia_props (  
	`page_id` int(10) NOT NULL,
	`propname`  int(10) NOT NULL,
	`props` blob NOT NULL,
PRIMARY KEY (`page_id`,`propname`) );
