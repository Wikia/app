CREATE TABLE IF NOT EXISTS `photo_gallery_feeds` (
-- URL to feed
  `url` varchar(255) NOT NULL,
-- timestamp
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
-- serialized data about images
  `data` blob NOT NULL,
  PRIMARY KEY (`url`),
  KEY (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;