--
-- SQL schema update for OpenID extension to add the uoi_user_registration field
--
ALTER TABLE /*_*/user_openid ADD uoi_user_registration BINARY(14);
