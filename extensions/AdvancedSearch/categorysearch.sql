--
-- Table used to do category intersections
--
-- This table must be MyISAM; InnoDB does not support the needed
-- fulltext index.
--
CREATE TABLE /*$wgDBprefix*/categorysearch (
  -- Key to page_id
  cs_page int unsigned NOT NULL,
  
  -- Munged version of categories
  -- E.g.: "Foo Living_people Bar"
  cs_categories mediumtext NOT NULL,

  UNIQUE KEY (cs_page),
  FULLTEXT cs_categories (cs_categories)

) TYPE=MyISAM;
