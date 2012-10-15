--
-- SQL schema update for OpenID extension to make the uoi_user field not unique
--

ALTER TABLE /*_*/user_openid DROP INDEX uoi_user;
CREATE INDEX /*i*/user_openid_user ON /*_*/user_openid(uoi_user);
