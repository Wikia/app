CREATE TABLE `wmetrics_group` (
  `wmgr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmgr_name` varchar(255) DEFAULT NULL,
  `wmgr_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`wmgr_id`)
) ENGINE=InnoDB

CREATE TABLE `wmetrics_group_reports_map` (
  `wmgrm_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmgrm_report_id` int(11) NOT NULL DEFAULT '0',
  `wmgrm_group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wmgrm_id`),
  KEY `wmgrm_report_id` (`wmgrm_report_id`),
  KEY `wmgrm_group_id` (`wmgrm_group_id`),
  CONSTRAINT `wmetrics_group_reports_map_ibfk_1` FOREIGN KEY (`wmgrm_report_id`) REFERENCES `wmetrics_report` (`wmre_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wmetrics_group_reports_map_ibfk_2` FOREIGN KEY (`wmgrm_group_id`) REFERENCES `wmetrics_group` (`wmgr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB

CREATE TABLE `wmetrics_report` (
  `wmre_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmre_name` varchar(255) DEFAULT NULL,
  `wmre_description` varchar(255) DEFAULT NULL,
  `wmre_frequency` int(11) DEFAULT '0',
  `wmre_steps` int(11) DEFAULT '0',
  `wmre_teaser` int(3) DEFAULT NULL,
  PRIMARY KEY (`wmre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1

CREATE TABLE `wmetrics_source` (
  `wmso_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmso_type` varchar(16) DEFAULT NULL,
  `wmso_report_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`wmso_id`),
  KEY `wmso_report_id` (`wmso_report_id`),
  CONSTRAINT `wmso_report_id` FOREIGN KEY (`wmso_report_id`) REFERENCES `wmetrics_report` (`wmre_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB

CREATE TABLE `wmetrics_source_params` (
  `wmsop_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmsop_source_id` int(11) NOT NULL DEFAULT '0',
  `wmsop_type` varchar(16) DEFAULT NULL,
  `wmsop_value` varchar(2500) DEFAULT NULL,
  PRIMARY KEY (`wmsop_id`),
  KEY `wmsop_source_id` (`wmsop_source_id`),
  CONSTRAINT `wmsop_source_id` FOREIGN KEY (`wmsop_source_id`) REFERENCES `wmetrics_source` (`wmso_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB

CREATE TABLE `wmetrics_user` (
  `wmusr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmusr_user_id` int(11) NOT NULL DEFAULT '0',
  `wmusr_type` int(11) NOT NULL DEFAULT '0',
  `wmusr_status` int(11) NOT NULL DEFAULT '0',
  `wmusr_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `wmusr_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`wmusr_id`)
) ENGINE=InnoDB

CREATE TABLE `wmetrics_user_group_map` (
  `wmgum_id` int(11) NOT NULL AUTO_INCREMENT,
  `wmgum_group_id` int(11) NOT NULL,
  `wmgum_user_id` int(11) NOT NULL,
  PRIMARY KEY (`wmgum_id`),
  KEY `wmgum_user_id` (`wmgum_user_id`),
  KEY `wmgum_group_id` (`wmgum_group_id`),
  CONSTRAINT `wmetrics_user_group_map_ibfk_1` FOREIGN KEY (`wmgum_user_id`) REFERENCES `wmetrics_user` (`wmusr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `wmetrics_user_group_map_ibfk_2` FOREIGN KEY (`wmgum_group_id`) REFERENCES `wmetrics_group` (`wmgr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB