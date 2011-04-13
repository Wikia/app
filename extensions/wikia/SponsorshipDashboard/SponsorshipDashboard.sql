CREATE TABLE wmetrics_group (
	wmgr_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmgr_name VARCHAR(255),
	wmgr_description VARCHAR(255),
) Engine=InnoDB;

CREATE TABLE wmetrics_report (
	wmre_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmre_name VARCHAR(255),
	wmre_description VARCHAR(255),
	wmre_frequency INT DEFAULT '0',
	wmre_steps INT DEFAULT '0',
) Engine=InnoDB;

CREATE TABLE wmetrics_source (
	wmso_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmso_type VARCHAR(16),
	wmso_report_id  INT NOT NULL DEFAULT '0',
	CONSTRAINT wmre_report_id FOREIGN KEY ( wmre_report_id )
		REFERENCES wmetrics_report( wmre_id )
		ON DELETE CASCADE
		ON UPDATE CASCADE
) Engine=InnoDB;

CREATE TABLE wmetrics_source_params (
	wmsop_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmsop_source_id  INT NOT NULL DEFAULT '0',
	wmsop_type VARCHAR(16),
	wmsop_value VARCHAR(255)
	CONSTRAINT wmsop_source_id FOREIGN KEY ( wmsop_source_id )
		REFERENCES wmetrics_source( wmso_id )
		ON DELETE CASCADE
		ON UPDATE CASCADE
) Engine=InnoDB;

CREATE TABLE wmetrics_group_reports_map (
	wmgrm_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmgrm_report_id  INT NOT NULL DEFAULT '0',
	wmgrm_group_id INT NOT NULL DEFAULT '0',
	CONSTRAINT FOREIGN KEY (`wmgrm_report_id`) 
		REFERENCES `wmetrics_report` (`wmre_id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
	CONSTRAINT FOREIGN KEY (`wmgrm_group_id`)
		REFERENCES `wmetrics_group` (`wmgr_id`)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) Engine=InnoDB;

CREATE TABLE wmetrics_user (
	wmusr_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmusr_user_id INT NOT NULL DEFAULT '0',
	wmusr_type INT NOT NULL DEFAULT '0',
	wmusr_name VARCHAR(255),
	wmusr_status INT NOT NULL DEFAULT '0',
	wmusr_desription VARCHAR(255)
) Engine=InnoDB;

CREATE TABLE wmetrics_user_group_map (
	wmgum_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wmgum_group_id INT NOT NULL,
	wmgum_user_id  INT NOT NULL,
	CONSTRAINT FOREIGN KEY (`wmgum_user_id`) REFERENCES `wmetrics_user` (`wmusr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FOREIGN KEY (`wmgum_group_id`) REFERENCES `wmetrics_group` (`wmgr_id`) ON DELETE CASCADE ON UPDATE CASCADE
) Engine=InnoDB;