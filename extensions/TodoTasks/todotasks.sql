-- Table structure for table `Todo Tasks`
CREATE TABLE /*$wgDBprefix*/todo (
	id   INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	hash TINYBLOB
) /*$wgDBTableOptions*/;
