-- Table for keeping user properties localized per wiki

CREATE TABLE /*$wgDBprefix*/wikia_user_properties (

  -- Multiple key 1, user id
  wup_user INT NOT NULL,

  -- Multiple key 2, name of property
  wup_property VARBINARY(255) NOT NULL DEFAULT '',

  -- Property value
  wup_value BLOB NULL DEFAULT NULL,

  PRIMARY KEY (wup_user, wup_property)
)/*$wgDBTableOptions*/;

CREATE INDEX wup_property_idx ON wikia_user_properties(wup_property);
