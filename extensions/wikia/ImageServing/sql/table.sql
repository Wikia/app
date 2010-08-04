CREATE TABLE `page_wikia_props` (  
	`page_id` int(10) NOT NULL,
	`propname` varchar(60) NOT NULL,
	`props` blob NOT NULL,
PRIMARY KEY (`page_id`,`propname`) );