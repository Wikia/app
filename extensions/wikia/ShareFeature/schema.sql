CREATE TABLE /*$wgDBprefix*/ `share_feature` (
  `sf_user_id` int(5) unsigned NOT NULL,
  `sf_provider_id` int(2) unsigned NOT NULL,
  `sf_clickcount` int(11) default '0',
  PRIMARY KEY (sf_user_id, sf_provider_id)
);

INSERT INTO `share_feature` VALUES (0, 0, 1000);
INSERT INTO `share_feature` VALUES (0, 1, 900);
INSERT INTO `share_feature` VALUES (0, 2, 800);
INSERT INTO `share_feature` VALUES (0, 3, 700);
INSERT INTO `share_feature` VALUES (0, 4, 600);
INSERT INTO `share_feature` VALUES (0, 5, 500);
INSERT INTO `share_feature` VALUES (0, 6, 400);
INSERT INTO `share_feature` VALUES (0, 7, 300);

