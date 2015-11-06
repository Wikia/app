CREATE TABLE /*$wgDBprefix*/page_wikia_props (
       `page_id` int(10) NOT NULL,
       `propname` int(10) NOT NULL,
       `props` blob NOT NULL,
       KEY `page_id` (`page_id`),
       KEY `propname` (`propname`)
) ENGINE=InnoDB;
