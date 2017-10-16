CREATE TABLE /*$wgDBprefix*/city_cats (
  `cat_id` int(9) NOT NULL,
  `cat_name` varchar(255) default NULL,
  `cat_url` text,
  `cat_short` varchar(255) default NULL,
  `cat_deprecated` boolean default 0,
  `cat_active` boolean default 0,
  PRIMARY KEY  (`cat_id`),
  KEY `cat_name_idx` (`cat_name`)
) ENGINE=InnoDB;

/* Old categories have the "deprecated" flag set
 * New categories have the "active" flag set
 * Category queries will have to be updated to join against this table during the transition

REPLACE INTO /*$wgDBprefix*/city_cats (cat_id, cat_name, cat_url, cat_short, cat_deprecated, cat_active ) VALUES
( 1, 'Humor', 'http://www.wikia.com/wiki/Humor', 'humor', 1, 1 ),
( 2, 'Gaming', 'http://gaming.wikia.com/', 'gaming', 1, 0 ),
( 3, 'Entertainment', 'http://entertainment.wikia.com/', 'ent', 1, 0 ),
( 4, 'Wikia', 'http://www.wikia.com/wiki/Category:Hubs', 'wikia', 1, 0 ),
( 5, 'Toys', 'http://www.wikia.com/wiki/Toys', 'toys', 1, 1 ),
( 6, 'Food and Drink', 'http://www.wikia.com/wiki/FoodAndDrink', 'foodanddrink', 1, 1 ),
( 7, 'Travel', 'http://www.wikia.com/wiki/Travel', 'travel', 1, 1 ),
( 8, 'Education', 'http://www.wikia.com/wiki/Education', 'edu', 1, 1 ),
( 9, 'Lifestyle', 'http://www.wikia.com/wiki/Lifestyle', 'life', 1, 0 ),
( 10, 'Finance', 'http://www.wikia.com/wiki/Finance', 'fin', 1, 1 ),
( 11, 'Politics', 'http://www.wikia.com/wiki/Politics', 'poli', 1, 1 ),
( 12, 'Technology', 'http://www.wikia.com/wiki/Technology', 'tech', 1, 1 ),
( 13, 'Science', 'http://www.wikia.com/wiki/Science', 'sci', 1, 1 ),
( 14, 'Philosophy', 'http://www.wikia.com/wiki/Philosophy', 'phil', 1, 1 ),
( 15, 'Sports', 'http://www.wikia.com/wiki/Sports', 'sports', 1, 1 ),
( 16, 'Music', 'http://www.wikia.com/wiki/Music', 'music', 1, 1 ),
( 17, 'Creative', 'http://www.wikia.com/wiki/Creative', 'crea', 1, 1 ),
( 18, 'Auto', 'http://www.wikia.com/wiki/Auto', 'auto', 1, 1 ),
( 19, 'Green', 'http://www.wikia.com/wiki/Green', 'green', 1, 0 ),
( 20, 'Wikianswers', 'http://www.wikia.com/wiki/Answers', 'answers', 1, 0 );

/* New categories */
REPLACE INTO /*$wgDBprefix*/city_cats (cat_id, cat_name, cat_url, cat_short, cat_deprecated, cat_active ) VALUES
( 21, 'TV', 'http://www.wikia.com/wiki/TV', 'tv', 0, 1),
( 22, 'Video Games', 'http://gaming.wikia.com', 'videogames', 0, 1),
( 23, 'Books', 'http://www.wikia.com/wiki/Books', 'books', 0, 1),
( 24, 'Comics', 'http://www.wikia.com/wiki/Comics', 'comics', 0, 1),
( 25, 'Fanon', 'http://www.wikia.com/wiki/Fanon', 'fanon', 0, 1),
( 26, 'Home and Garden', 'http://www.wikia.com/wiki/HomeAndGarden', 'homeandgarden', 0, 1),
( 27, 'Movies', 'http://www.wikia.com/wiki/Movies', 'movies', 0, 1),
( 28, 'Anime', 'http://www.wikia.com/wiki/Anime', 'anime', 0, 1);

/* New table for verticals.  Some old categories (which were known as "hubs") overlap with the new verticals */
CREATE TABLE `city_verticals` (
  `vertical_id` int(9) NOT NULL,
  `vertical_name` varchar(255) default NULL,
  `vertical_url` text,
  `vertical_short` varchar(255) DEFAULT NULL,
  PRIMARY KEY  (`vertical_id`),
  KEY `vertical_name_idx` (`vertical_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

REPLACE INTO /*$wgDBprefix*/city_verticals (vertical_id, vertical_name, vertical_url, vertical_short ) VALUES
( 0, 'Other', 'http://www.wikia.com', 'other' ),
( 1, 'TV', 'http://tvhub.wikia.com/', 'tv' ),
( 2, 'Games', 'http://gameshub.wikia.com/', 'games' ),
( 3, 'Books', 'http://bookshub.wikia.com/', 'books' ),
( 4, 'Comics', 'http://comicshub.wikia.com/', 'comics' ),
( 5, 'Lifestyle', 'http://lifestylehub.wikia.com/', 'lifestyle' ),
( 6, 'Music', 'http://musichub.wikia.com/', 'music' ),
( 7, 'Movies', 'http://movieshub.wikia.com/', 'movies' );
