CREATE TABLE wikiahubsv2_slider (
  hub_id INT(11),
  slide_id INT(11),
  ordering INT(11),
  slider_image_id INT(11),
  slider_image_href VARCHAR(255),
  slider_image_title VARCHAR(255),
  slider_image_headline VARCHAR(255),
  slider_image_description VARCHAR(255),
  hub_date DATE,
  KEY hv2_s_pk (hub_id, slide_id),
  FOREIGN KEY (hub_id) REFERENCES wikiahubsv2(hub_id) ON DELETE CASCADE
) ENGINE=InnoDB;