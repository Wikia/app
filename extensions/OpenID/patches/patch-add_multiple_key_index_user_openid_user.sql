--
-- SQL schema update for OpenID extension to add a non unique uoi_user index
--

CREATE INDEX /*i*/user_openid_user ON /*_*/user_openid(uoi_user);
