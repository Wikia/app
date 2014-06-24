CREATE TABLE /*$wgDBprefix*/city_cats (
  `cat_id` int(9) NOT NULL,
  `cat_name` varchar(255) default NULL,
  `cat_url` text,
  `cat_short` varchar(255) default NULL,
  PRIMARY KEY  (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB;

REPLACE INTO /*$wgDBprefix*/city_cats (cat_id, cat_name, cat_url, cat_short ) VALUES
( 1, 'Humor', 'http://www.wikia.com/wiki/Humor', 'humor' ),
( 2, 'Gaming', 'http://gaming.wikia.com/', 'gaming' ),
( 3, 'Entertainment', 'http://entertainment.wikia.com/', 'ent' ),
( 4, 'Wikia', 'http://www.wikia.com/wiki/Category:Hubs', 'wikia' ),
( 5, 'Toys', 'http://www.wikia.com/wiki/Toys', 'toys'),
( 7, 'Travel', 'http://www.wikia.com/wiki/Travel', 'travel' ),
( 8, 'Education', 'http://www.wikia.com/wiki/Education', 'edu' ),
( 9, 'Lifestyle', 'http://www.wikia.com/wiki/Lifestyle', 'life' ),
( 10, 'Finance', 'http://www.wikia.com/wiki/Finance', 'fin' ),
( 11, 'Politics', 'http://www.wikia.com/wiki/Politics', 'poli' ),
( 12, 'Technology', 'http://www.wikia.com/wiki/Technology', 'tech' ),
( 13, 'Science', 'http://www.wikia.com/wiki/Science', 'sci' ),
( 14, 'Philosophy', 'http://www.wikia.com/wiki/Philosophy', 'phil' ),
( 15, 'Sports', 'http://www.wikia.com/wiki/Sports', 'sports' ),
( 16, 'Music', 'http://www.wikia.com/wiki/Music', 'music' ),
( 17, 'Creative', 'http://www.wikia.com/wiki/Creative', 'crea' ),
( 18, 'Auto', 'http://www.wikia.com/wiki/Auto', 'auto' ),
( 19, 'Green', 'http://www.wikia.com/wiki/Green', 'green' ),
( 20, 'Wikianswers', 'http://www.wikia.com/wiki/Answers', 'answers' );

/* New categories */
REPLACE INTO /*$wgDBprefix*/city_cats (cat_id, cat_name, cat_url, cat_short ) VALUES
( 1, 'Humor', 'http://www.wikia.com/wiki/Humor', 'humor' ),
( 2, 'Gaming', 'http://gaming.wikia.com/', 'gaming' ),



CREATE TABLE `city_hubs` (
  `hub_id` int(9) NOT NULL auto_increment,
  `hub_name` varchar(255) default NULL,
  `hub_url` text,
  `hub_short` varchar(255) DEFAULT NULL,
  PRIMARY KEY  (`hub_id`),
  KEY `hub_name_idx` (`hub_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

REPLACE INTO /*$wgDBprefix*/city_hubs (hub_id, hub_name, hub_url, hub_short ) VALUES
( 0, 'Other', 'http://www.wikia.com', 'other' ),
( 1, 'Video Games', 'http://gameshub.wikia.com/', 'games' ),
( 2, 'Movies', 'http://movieshub.wikia.com/', 'movies' ),
( 3, 'Comics', 'http://comicshub.wikia.com/', 'comics' ),
( 4, 'Books', 'http://bookshub.wikia.com/', 'books' ),
( 5, 'TV', 'http://tvhub.wikia.com/', 'tv' ),
( 6, 'Music', 'http://musichub.wikia.com/', 'music' ),
( 7, 'Lifestyle', 'http://lifestylehub.wikia.com/', 'lifestyle' );
