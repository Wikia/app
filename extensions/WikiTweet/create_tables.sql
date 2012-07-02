--
-- Table structure for table `mw_wikitweet_alerts`
--

DROP TABLE IF EXISTS `mw_wikitweet`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet` (
  `id` int(11) NOT NULL auto_increment,
  `text` varchar(500) default NULL,
  `user` varchar(100) NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `room` varchar(50) NOT NULL default 'main',
  `show` int(11) NOT NULL default '1',
  `status` int(11) NOT NULL default '1',
  `parent` int(11) default '0',
  `lastupdatedate` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mw_wikitweet_alerts`
--

DROP TABLE IF EXISTS `mw_wikitweet_alerts`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet_alerts` (
  `id` int(11) NOT NULL auto_increment,
  `date` varchar(100) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `attention` int(11) NOT NULL default '0',
  `alert` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mw_wikitweet_alerts_persons`
--

DROP TABLE IF EXISTS `mw_wikitweet_alerts_persons`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet_alerts_persons` (
  `id` int(11) NOT NULL auto_increment,
  `date` varchar(100) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `attention` int(11) NOT NULL default '0',
  `alert` int(11) NOT NULL default '0',
  `username` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mw_wikitweet_avatar`
--

DROP TABLE IF EXISTS `mw_wikitweet_avatar`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet_avatar` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(200) NOT NULL,
  `avatar` varchar(1000) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mw_wikitweet_charge`
--

DROP TABLE IF EXISTS `mw_wikitweet_charge`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet_charge` (
  `id` int(11) NOT NULL auto_increment,
  `chantier` varchar(200) NOT NULL,
  `jalon` varchar(1000) NOT NULL,
  `charge` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mw_wikitweet_responsibles`
--

DROP TABLE IF EXISTS `mw_wikitweet_responsibles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet_responsibles` (
  `id` int(11) NOT NULL auto_increment,
  `ref` varchar(100) NOT NULL default '',
  `title` varchar(300) NOT NULL default '',
  `responsible` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mw_wikitweet_subscription`
--

DROP TABLE IF EXISTS `mw_wikitweet_subscription`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mw_wikitweet_subscription` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
SET character_set_client = @saved_cs_client;
