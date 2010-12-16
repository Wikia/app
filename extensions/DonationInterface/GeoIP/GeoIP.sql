CREATE TABLE IF NOT EXISTS `geoip` (
  `begin_ip_long` int(10) unsigned NOT NULL,
  `end_ip_long` int(10) unsigned NOT NULL,
  `country_code` char(2) NOT NULL,
  KEY `begin_ip_long` (`begin_ip_long`)
) ENGINE=InnoDB DEFAULT CHARSET=binary;
