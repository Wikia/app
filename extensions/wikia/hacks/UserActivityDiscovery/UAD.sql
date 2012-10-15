CREATE TABLE uad_token (
	uto_id INT NOT NULL AUTO_INCREMENT,
	uto_value VARCHAR(32),
	uto_created DATETIME,
	PRIMARY KEY (uto_id),
	KEY uto_value (uto_value)
) Type=InnoDB;

CREATE TABLE uad_event (
	uev_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	uev_token VARCHAR(32) NOT NULL,
	uev_type VARCHAR(64),
	uev_date DATE,
	uev_value INT DEFAULT '1',
	CONSTRAINT uev_token FOREIGN KEY (uev_token) REFERENCES uad_token(uto_value) ON DELETE CASCADE ON UPDATE CASCADE
) Type=InnoDB;
