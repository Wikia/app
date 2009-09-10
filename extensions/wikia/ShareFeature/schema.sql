CREATE TABLE /*$wgDBprefix*/ `share_feature` (
  `sf_user_id` int(5) unsigned NOT NULL,
  `sf_provider_id` int(2) unsigned NOT NULL,
  `sf_clickcount` int(11) default '0',
  PRIMARY KEY (sf_user_id, sf_provider_id)
);
