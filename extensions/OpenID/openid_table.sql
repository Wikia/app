CREATE TABLE /*$wgDBprefix*/user_openid (
  uoi_openid varchar(255) NOT NULL,
  uoi_user int(5) unsigned NOT NULL,
  
  PRIMARY KEY uoi_openid (uoi_openid),
  UNIQUE INDEX uoi_user (uoi_user)
) TYPE=InnoDB;
