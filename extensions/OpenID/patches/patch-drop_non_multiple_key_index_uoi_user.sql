--
-- SQL schema update for OpenID extension to drop uoi_user field because it is unique
--

ALTER TABLE /*_*/user_openid DROP INDEX uoi_user;
