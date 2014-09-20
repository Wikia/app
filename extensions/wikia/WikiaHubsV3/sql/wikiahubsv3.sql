CREATE TABLE `wikia_hub_modules` (
  `city_id` int NOT NULL DEFAULT 0,
  `lang_code` varchar(8) NOT NULL,
  `vertical_id` tinyint NOT NULL, /* in sync with comscore id (2-gaming, 3-entertainment, 9-lifestyle) */
  `hub_date` date  NOT NULL,
  `module_id` tinyint NOT NULL,
  `module_data` blob,
  `module_status` tinyint NOT NULL DEFAULT 1, /* in sync with CT statuses: 1-saved, 2-published */
  `last_editor_id` int(11),
  `last_edit_timestamp` timestamp,
  PRIMARY KEY ( `lang_code`, `vertical_id`, `hub_date`, `module_id`, `city_id` )
) ENGINE=InnoDB;
