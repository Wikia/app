<?php
/**
 * A few constants that might be needed in Wikia code
 */

/**
 * @name DB_DPL
 * index for database slave used in heavies queries like DPL. Change to
 * define("DB_DPL", -1);
 * for using all slaves
 */
define("DB_DPL", 3);

/**
 * @name DB_SLAVE_BEFORE_MASTER
 * added by Wikia - wladek
 * this option is experimental (only a couple of functions support this value)
 */
define('DB_SLAVE_BEFORE_MASTER',-100);

/**
 * Defines for Forum namespace
 */
define('NS_FORUM', 110);
define('NS_FORUM_TALK', 111);

/*
 * wikia page props type
 *
 */

define("WPP_IMAGE_SERVING", 0);
define("WPP_PLB_PROPS", 1);
define("WPP_PLB_LAYOUT_DELETE", 2);
define("WPP_PLB_LAYOUT_NOT_PUBLISH", 3);
define("WPP_BLOGS_VOTING", 4);
define("WPP_BLOGS_COMMENTING", 5);
define("WPP_PLACES_LATITUDE", 6);
define("WPP_PLACES_LONGITUDE", 7);

define("WPP_PLACES_CATEGORY_GEOTAGGED", 9);
//Wall flags
define("WPP_WALL_COUNT", 8);
define("WPP_WALL_ADMINDELETE", 10);
define("WPP_WALL_ARCHIVE", 11);
define("WPP_WALL_ACTIONREASON", 12);
define("WPP_WALL_REMOVE", 13);
define("WPP_WALL_POSTEDBYBOT", 14);
define("WPP_WALL_MODERATORREMOVE", 25);
define("WPP_WALL_MODERATORARCHIVE", 26);
define("WPP_WALL_MODERATORREOPEN", 27);

//Content warning
define("WPP_CONTENT_WARNING", 15);

//More wall flags
define("WPP_WALL_QUOTE_OF", 16);

//Forum Order
define("WPP_WALL_ORDER_INDEX", 17);

// LyricFind
define( "WPP_LYRICFIND_MARKED_FOR_REMOVAL", 23 );

// Video status (ie, working, deleted, private, other)
define("WPP_VIDEO_STATUS", 24);

// Palantir metadata
define("WPP_PALANTIR_METADATA", 250);

// Any types listed in this array will not have their values serialized
// This should only be used for properties that are simple strings or integers
$wgWPPNotSerialized = array( WPP_LYRICFIND_MARKED_FOR_REMOVAL, WPP_VIDEO_STATUS );

define( 'PREFERENCE_EDITOR', 'editor' );
