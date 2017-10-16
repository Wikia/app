CREATE TABLE `portability_dashboard` (
  `wiki_id` int(11) NOT NULL,
  `portability` decimal(5,4) DEFAULT NULL,
  `infobox_portability` decimal(5,4) DEFAULT NULL,
  `traffic` int(11) DEFAULT NULL,
  `migration_impact` int(11) DEFAULT NULL,
  `typeless` int(11) DEFAULT NULL,
  `custom_infoboxes` int(11) DEFAULT NULL,
  `excluded` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`wiki_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
