DROP TABLE IF EXISTS `city_variables`;
CREATE TABLE `city_variables` (
  `cv_city_id` int,
  `cv_variable_id` smallint unsigned DEFAULT '0',
  `cv_value` text
);

DROP TABLE IF EXISTS `city_variables_pool`;
CREATE TABLE `city_variables_pool` (
  `cv_id` smallint unsigned,
  `cv_name` varchar(255),
  `cv_description` text,
  `cv_variable_type` text DEFAULT 'integer',
  `cv_variable_group` tinyint unsigned DEFAULT '1',
  `cv_access_level` tinyint unsigned DEFAULT '1',
  `cv_is_unique` int(1) DEFAULT '0'
);