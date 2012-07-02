CREATE TABLE /*_*/sourcetracking (
  `trackingid` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userid` int(10) NOT NULL,
  `source_action` varbinary(255) DEFAULT NULL,
  `source_ns` int(11) NOT NULL,
  `source_article` int(10) NOT NULL
)/*$wgDBTableOptions*/;
