-- Table for keeping user properties localized per wiki

CREATE TABLE /*$wgDBprefix*/wikia_user_properties (

  -- Multiple key 1, user id
  wup_user INT NOT NULL,

  -- Multiple key 2, name of property
  wup_property VARBINARY(255) NULL DEFAULT NULL,

  -- Property value
  wup_value BLOB NULL DEFAULT NULL,

  UNIQUE INDEX (wup_user, wup_property),
  INDEX (wup_property)
)/*$wgDBTableOptions*/;