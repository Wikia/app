--
-- SQL schema for OpenID extension
--

CREATE TABLE /*$wgDBprefix*/user_openid (
  uoi_openid varchar(255) NOT NULL PRIMARY KEY,
  uoi_user int(5) unsigned NOT NULL
) /*$wgDBTableOptions*/;

CREATE INDEX /*$wgDBprefix*/user_openid_user ON /*$wgDBprefix*/user_openid(uoi_user);
