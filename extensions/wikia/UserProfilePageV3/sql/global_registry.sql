-- DATABASE: DATAWARE

CREATE TABLE `global_registry` (
  `item_id` int(10) NOT NULL,
  `item_type` int(10) NOT NULL,
  `item_value` blob NOT NULL,
  `item_updated` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`,`item_type`)
) ENGINE=InnoDB;