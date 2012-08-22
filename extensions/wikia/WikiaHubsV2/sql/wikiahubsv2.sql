CREATE TABLE wikiahubsv2 (
  hub_id INT(11),
  hub_vertical_id INT(11), /* in sync with comscore id (2-gaming, 3-entertainment, 9-lifestyle) */
  hub_lang VARCHAR(8),
  hub_date DATE,
  hub_last_change TIMESTAMP,
  KEY hv2_pk (hub_vertical, hub_lang, hub_date),
  UNIQUE (hub_id)
) ENGINE=InnoDB;