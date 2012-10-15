CREATE TABLE /*_*/GenericDataTable (
  `date`           date NOT NULL,
  `language_code`  char (15) DEFAULT NULL,
  `project_code`   varchar (10) DEFAULT NULL,
  `country_code`   varchar (3) DEFAULT NULL,
  `value`          bigint (12),-- Needs to be decimal?
  PRIMARY KEY ( date, language_code, project_code, country_code, value )
  -- More indexes may be needed where language, project and country could be null
) ;