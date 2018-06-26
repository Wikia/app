DROP TABLE IF EXISTS `spoofuser`;
CREATE TABLE `spoofuser` (
  `su_name` varchar(255) NOT NULL DEFAULT '' PRIMARY KEY,
  `su_normalized` varchar(255) DEFAULT NULL,
  `su_legal` tinyint(1) DEFAULT NULL,
  `su_error` text,
  `su_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `spoofuser_forgotten`;
CREATE TABLE `spoofuser_forgotten` (
  `suf_id` int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `suf_exact_hash` char(64) NOT NULL UNIQUE,
  `suf_normalized_hash` char(64) NOT NULL UNIQUE,
  `suf_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
);
