-- Table for keeping user properties localized per wiki

CREATE TABLE /*$wgDBprefix*/wikia_user_properties (

  -- Multiple key 1, user id
  wup_user INT NOT NULL,

  -- Multiple key 2, name of property
  wup_property VARBINARY(255) NULL DEFAULT NULL,

  -- Property value
  wup_value BLOB NULL DEFAULT NULL
)/*$wgDBTableOptions*/;

CREATE UNIQUE INDEX wup_user_property_idx ON wikia_user_properties(wup_user, wup_property);
CREATE INDEX wup_property_idx ON wikia_user_properties(wup_property);
