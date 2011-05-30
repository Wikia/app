-- SQL tables for Translate extension

-- List of each section which has a name and text
CREATE TABLE /*_*/translate_sections (
  -- Key to page_id
  trs_page int unsigned NOT NULL,

  -- Customizable section name
  trs_key varchar(255) binary NOT NULL,

  -- Section contents
  trs_text mediumblob NOT NULL,

  -- Section order
  trs_order int unsigned,

  PRIMARY KEY (trs_page, trs_key)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/trs_page on /*_*/translate_sections (trs_page);
