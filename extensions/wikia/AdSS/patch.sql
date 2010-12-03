CREATE TABLE ad_changes (
	adc_ad_id int unsigned NOT NULL PRIMARY KEY,
	adc_url text NULL DEFAULT NULL,
	adc_text text NULL DEFAULT NULL,
	adc_desc text NULL DEFAULT NULL,
	adc_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
