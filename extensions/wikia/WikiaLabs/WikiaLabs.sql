
CREATE TABLE wikia_labs_project (
	wlpr_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wlpr_name VARCHAR(64),
	wlpr_data TEXT,
	wlpr_release_date DATE,
	wlpr_is_active ENUM('y','n') DEFAULT 'n',
	wlpr_is_graduated ENUM('y','n') DEFAULT 'n'
	wlpr_activations_num INT DEFAULT '0',
	wlpr_rating DECIMAL(10,2) DEFAULT '0.00',
	wlpr_pm_email VARCHAR(64),
	wlpr_tech_email VARCHAR(64),
	wlpr_fogbugz_project VARCHAR(64)
) Engine=InnoDB;

CREATE TABLE wikia_labs_project_rating (
	wlpra_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	wlpra_wlpr_id INT NOT NULL DEFAULT '0',
	wlpra_user_id INT,
	wlpra_value TINYINT,
	CONSTRAINT wlpra_wlpr_id FOREIGN KEY (wlpra_wlpr_id)
		REFERENCES wikia_labs_project(wlpr_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) Engine=InnoDB;
