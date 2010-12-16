--
-- SQL schema update for OpenID extension to make the uoi_user field not unique
--

ALTER TABLE /*$wgDBprefix*/user_openid DROP INDEX uoi_user;
CREATE INDEX /*$wgDBprefix*/user_openid_user ON /*$wgDBprefix*/user_openid(uoi_user);
