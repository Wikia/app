CREATE TABLE /*$wgDBprefix*/bad_images (
  `bil_name` varbinary(255) NOT NULL,
  `bil_timestamp` varchar(14) NOT NULL,
  `bil_user` int(11) NOT NULL,
  `bil_reason` varbinary(255) NOT NULL,
  UNIQUE KEY `bil_name` (`bil_name`)
) TYPE=InnoDB;