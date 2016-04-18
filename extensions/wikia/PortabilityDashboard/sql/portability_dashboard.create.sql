CREATE TABLE `portability_dashboard` (
  `wiki_id` int(11) NOT NULL,
  `portability` decimal(5,4) DEFAULT 0,
  `infobox_portability` decimal(5,4) DEFAULT 0,
  `traffic` int(11) DEFAULT 0,
  `migration_impact` int(11) DEFAULT 0,
  `typeless` int(11) DEFAULT 0,
  `custom_infoboxes` int(11) DEFAULT 0,
  PRIMARY KEY (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
