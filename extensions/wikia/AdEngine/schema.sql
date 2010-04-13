-- Providers DROP TABLE IF EXISTS ad_provider;
DROP TABLE IF EXISTS ad_provider;
CREATE TABLE ad_provider (
        provider_id TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
        provider_name VARCHAR(25),
        PRIMARY KEY(provider_id)
) ENGINE=InnoDB;
INSERT INTO ad_provider VALUES (1, 'DART');
INSERT INTO ad_provider VALUES (2, 'OpenX');
INSERT INTO ad_provider VALUES (3, 'Google');
INSERT INTO ad_provider VALUES (4, 'GAM');
INSERT INTO ad_provider VALUES (5, 'PubMatic');
INSERT INTO ad_provider VALUES (6, 'Athena');
INSERT INTO ad_provider VALUES (7, 'ContextWeb');
INSERT INTO ad_provider VALUES (8, 'DARTMobile');
INSERT INTO ad_provider VALUES (9, 'Liftium');


-- Slots
DROP TABLE IF EXISTS ad_slot;
CREATE TABLE ad_slot (
  as_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  slot VARCHAR(50) NOT NULL, 
  skin VARCHAR(25) NOT NULL, -- monaco, quartz, blah
  size varchar(25),
  load_priority TINYINT UNSIGNED DEFAULT NULL,
  default_provider_id TINYINT UNSIGNED NOT NULL,
  default_enabled ENUM('Yes', 'No') DEFAULT 'Yes',
  PRIMARY KEY(as_id),
  UNIQUE KEY (slot, skin)
) ENGINE=InnoDB;

INSERT INTO `ad_slot` VALUES (1,'HOME_TOP_LEADERBOARD','monaco','728x90',15,6,'Yes');
INSERT INTO `ad_slot` VALUES (2,'HOME_TOP_RIGHT_BOXAD','monaco','300x250',20,6,'Yes');
INSERT INTO `ad_slot` VALUES (3,'HOME_LEFT_SKYSCRAPER_1','monaco','160x600',10,6,'Yes');
INSERT INTO `ad_slot` VALUES (4,'HOME_LEFT_SKYSCRAPER_2','monaco','160x600',8,6,'No');
INSERT INTO `ad_slot` VALUES (5,'TOP_LEADERBOARD','monaco','728x90',15,6,'Yes');
INSERT INTO `ad_slot` VALUES (6,'TOP_RIGHT_BOXAD','monaco','300x250',20,6,'Yes');
INSERT INTO `ad_slot` VALUES (7,'LEFT_SKYSCRAPER_1','monaco','160x600',10,6,'Yes');
INSERT INTO `ad_slot` VALUES (8,'LEFT_SKYSCRAPER_2','monaco','160x600',8,6,'Yes');
INSERT INTO `ad_slot` VALUES (9,'FOOTER_BOXAD','monaco','300x250',4,3,'Yes');
INSERT INTO `ad_slot` VALUES (10,'LEFT_SPOTLIGHT_1','monaco','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (11,'FOOTER_SPOTLIGHT_LEFT','monaco','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (12,'FOOTER_SPOTLIGHT_MIDDLE','monaco','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (13,'FOOTER_SPOTLIGHT_RIGHT','monaco','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (14,'LEFT_SKYSCRAPER_3','monaco','160x600',6,6,'No');
INSERT INTO `ad_slot` VALUES (15,'RIGHT_SPOTLIGHT_1','monobook','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (16,'RIGHT_SKYSCRAPER_1','monobook','120x600',6,2,'Yes');
INSERT INTO `ad_slot` VALUES (17,'RIGHT_SPOTLIGHT_2','monobook','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (18,'LEFT_SPOTLIGHT_2','uncyclopedia','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (19,'TOP_RIGHT_BOXAD','quartz','300x250',20,4,'Yes');
INSERT INTO `ad_slot` VALUES (20,'RIGHT_SPOTLIGHT_1','quartz','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (21,'RIGHT_SPOTLIGHT_2','quartz','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (22,'LEFT_NAVBOX_1','monaco','200x200',3,4,'No');
INSERT INTO `ad_slot` VALUES (23,'LEFT_NAVBOX_2','monaco','200x200',3,4,'No');
INSERT INTO `ad_slot` VALUES (25,'PREFOOTER_LEFT_BOXAD','monaco','300x250',0,6,'Yes');
INSERT INTO `ad_slot` VALUES (26,'PREFOOTER_RIGHT_BOXAD','monaco','300x250',0,6,'No');
INSERT INTO `ad_slot` VALUES (65,'LEFT_SLIMBOX_1','monaco','205x600',0,4,'No');
INSERT INTO `ad_slot` VALUES (66,'ANSWERSCAT_LEADERBOARD_A','answers','728x90',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (67,'ANSWERSCAT_LEADERBOARD_U','answers','728x90',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (68,'ANSWERSCAT_LEADERBOARD_B','answers','728x90',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (69,'LEFT_SPOTLIGHT_1','awesome','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (70,'INVISIBLE_1','monaco','0x0',4,6,'Yes');
INSERT INTO `ad_slot` VALUES (71,'INVISIBLE_2','monaco','0x0',4,6,'Yes');
INSERT INTO `ad_slot` VALUES (72,'ANSWERSCAT_BOXAD_A','answers','300x250',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (73,'ANSWERSCAT_BOXAD_U','answers','300x250',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (74,'EXIT_STITIAL_INVISIBLE','monaco','1x1',25,6,'Yes');
INSERT INTO `ad_slot` VALUES (75,'EXIT_STITIAL_BOXAD_1','monaco','300x250',10,6,'Yes');
INSERT INTO `ad_slot` VALUES (76,'EXIT_STITIAL_BOXAD_2','monaco','300x250',10,6,'Yes');
INSERT INTO `ad_slot` VALUES (77,'FOOTER_SPOTLIGHT_RIGHT','uncyclopedia','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (78,'FOOTER_SPOTLIGHT_MIDDLE','uncyclopedia','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (79,'FOOTER_SPOTLIGHT_LEFT','uncyclopedia','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (80,'FOOTER_SPOTLIGHT_LEFT','monobook','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (81,'FOOTER_SPOTLIGHT_MIDDLE','monobook','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (82,'FOOTER_SPOTLIGHT_RIGHT','monobook','200x75',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (83,'RIGHT_SPOTLIGHT_1','uncyclopedia','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (84,'RIGHT_SPOTLIGHT_2','uncyclopedia','125x125',0,4,'Yes');
INSERT INTO `ad_slot` VALUES (85,'INVISIBLE_TOP','monaco','0x0',30,1,'Yes');
INSERT INTO `ad_slot` VALUES (86,'HOME_INVISIBLE_TOP','monaco','0x0',30,1,'Yes');
INSERT INTO `ad_slot` VALUES (87,'PREFOOTER_BIG','monaco','600x250',30,6,'Yes');
INSERT INTO `ad_slot` VALUES (88,'LEFT_NAV_205x400','monaco','205x400',0,4,'No');

-- Allow wikis to override slots
DROP TABLE IF EXISTS ad_slot_override;
CREATE TABLE ad_slot_override (
  as_id SMALLINT UNSIGNED NOT NULL,
  city_id INT UNSIGNED NOT NULL,
  provider_id TINYINT UNSIGNED DEFAULT NULL,
  enabled ENUM('Yes', 'No') DEFAULT NULL,
  comment text,
  PRIMARY KEY(as_id, city_id),
  KEY(city_id)
) ENGINE=InnoDB;

-- Store provider specific values like  key-values for DART
DROP TABLE IF EXISTS ad_provider_value;
CREATE TABLE ad_provider_value (
  apv_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  provider_id TINYINT UNSIGNED NOT NULL,
  city_id INT UNSIGNED DEFAULT NULL, -- null means that it is the default
  keyname VARCHAR(25),
  keyvalue VARCHAR(255),
  PRIMARY KEY (apv_id),
  UNIQUE KEY (city_id, keyname, keyvalue),
  KEY (provider_id, city_id)
) ENGINE=InnoDB;
