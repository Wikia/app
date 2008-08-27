-- Providers
DROP TABLE IF EXISTS ad_provider;
CREATE TABLE ad_provider (
        provider_id TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
        provider_name VARCHAR(25),
        PRIMARY KEY(provider_id)
) ENGINE=InnoDB;
INSERT INTO ad_provider VALUES (1, 'DART');
INSERT INTO ad_provider VALUES (2, 'Google');
INSERT INTO ad_provider VALUES (3, 'OpenX');


-- Slots
DROP TABLE IF EXISTS ad_slot;
CREATE TABLE ad_slot (
  as_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  slot VARCHAR(50) NOT NULL, 
  skin VARCHAR(25) NOT NULL, -- monaco, quartz, blah
  size varchar(25),
  default_provider_id TINYINT UNSIGNED NOT NULL,
  default_enabled ENUM('Yes', 'No') DEFAULT 'Yes',
  PRIMARY KEY(as_id),
  UNIQUE KEY (slot, skin)
) ENGINE=InnoDB;

INSERT INTO ad_slot VALUES (NULL, 'HOME_TOP_LEADERBOARD', 'monaco', '728x90', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'HOME_TOP_RIGHT_BOXAD', 'monaco', '300x250', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'HOME_LEFT_SKYSCRAPER_1', 'monaco', '160x600', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'HOME_LEFT_SKYSCRAPER_2', 'monaco', '160x600', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'TOP_LEADERBOARD', 'monaco', '728x90', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'TOP_RIGHT_BOXAD', 'monaco', '300x250', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'LEFT_SKYSCRAPER_1', 'monaco', '160x600', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'LEFT_SKYSCRAPER_2', 'monaco', '160x600', 1, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'FOOTER_BOXAD', 'monaco', '300x250', 3, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'LEFT_SPOTLIGHT_1', 'monaco', '200x75', 2, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'FOOTER_SPOTLIGHT_LEFT', 'monaco', '200x75', 2, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'FOOTER_SPOTLIGHT_MIDDLE', 'monaco', '200x75', 2, 'Yes');
INSERT INTO ad_slot VALUES (NULL, 'FOOTER_SPOTLIGHT_RIGHT', 'monaco', '200x75', 2, 'Yes');

-- Allow wikis to override slots
DROP TABLE IF EXISTS ad_slot_override;
CREATE TABLE ad_slot_override (
  as_id SMALLINT UNSIGNED NOT NULL,
  city_id INT UNSIGNED NOT NULL,
  provider_id TINYINT UNSIGNED DEFAULT NULL,
  enabled ENUM('Yes', 'No') DEFAULT NULL,
  PRIMARY KEY(as_id, city_id),
  KEY(city_id)
) ENGINE=InnoDB;

-- Store provider specific values like  key-values for DART
DROP TABLE IF EXISTS ad_provider_value;
CREATE TABLE ad_provider_value (
  apv_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  provider_id TINYINT UNSIGNED NOT NULL,
  city_id INT UNSIGNED DEFAULT NULL, -- null means that it is the default
  keyname VARCHAR(25),
  keyvalue VARCHAR(255),
  PRIMARY KEY (apv_id),
  KEY (provider_id, city_id)
) ENGINE=InnoDB;
