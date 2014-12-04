--
-- SQL schema for OpenID extension
--

CREATE TABLE /*_*/user_openid (
  uoi_openid varchar(255) NOT NULL PRIMARY KEY,
  uoi_user int(5) unsigned NOT NULL,
  uoi_user_registration binary(14)
) /*$wgDBTableOptions*/;

CREATE INDEX /*i*/user_openid_user ON /*_*/user_openid(uoi_user);
