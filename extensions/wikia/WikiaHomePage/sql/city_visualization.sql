CREATE TABLE city_visualization (
  city_id INT(11),
  city_description VARCHAR(255),
  city_main_image VARCHAR(255),
  city_flags SMALLINT(8), /*new, hot, promoted, excluded, new&hot, new&promoted, hot&promoted, new&excluded, hot&excluded, new&hot&excluded, new&hot&promoted, new&hot&excluded&promoted*/
  city_images text,
  KEY `cv_cid_cf` (city_id, city_flags),
  FOREIGN KEY (city_id) REFERENCES city_list(city_id) ON DELETE CASCADE
) ENGINE=InnoDB;