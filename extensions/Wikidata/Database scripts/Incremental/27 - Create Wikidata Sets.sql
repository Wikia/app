--
-- Table structure for table `wikidata_sets`
--

DROP TABLE IF EXISTS `wikidata_sets`;
CREATE TABLE `wikidata_sets` (
  `set_prefix` varchar(20) default NULL,
  `set_string` varchar(100) default NULL,
  `set_dmid` int(10) default NULL
);


LOCK TABLES `wikidata_sets` WRITE;
INSERT INTO `wikidata_sets` VALUES ('uw','OmegaWiki community',0),('umls','UMLS',0);
UNLOCK TABLES;


INSERT INTO `script_log` (`time`, `script_name`) VALUES (NOW(), '27 - Create Wikidata Sets.sql');