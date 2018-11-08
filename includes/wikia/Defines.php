<?php
/**
 * By the analogy to MediaWiki's includes/Defines.php, this file contains
 * FANDOM-specific constants of general purpose.
 * 
 * IMPORTANT: Only define constants here, that affect the behaviour of the
 * entire application. Constants tightly coupled with an extension must be
 * defined in the extension code. Constants specific to a small group of related
 * extensions must be defined in one of them. Those are proper dependency
 * handling practices that aid future maintenance and reverse engineering.
 * 
 * Keep the definitions in alphabetical order.
 */

/**
 * @name WIKIA_DC_POZ
 * Named constant for POZ (Poznań) datacenter.
 * @deprecated Code portability: do not add more datacenter-specific code.
 */
define( 'WIKIA_DC_POZ', 'poz' );

/**
 * @name WIKIA_DC_RES
 * Named constant for RES (Reston) datacenter.
 * @deprecated Code portability: do not add more datacenter-specific code.
 */
define( 'WIKIA_DC_RES', 'res' );

/**
 * @name WIKIA_DC_SJC
 * Named constant for SJC (San Jose) datacenter.
 * @deprecated Code portability: do not add more datacenter-specific code.
 */
define( 'WIKIA_DC_SJC', 'sjc' );

/**
 * @name WIKIA_ENV_DEV
 * Name constant for "dev" environment.
 * @deprecated Code portability: do not add more environment-specific code.
 */
define( 'WIKIA_ENV_DEV', 'dev' );

/**
 * @name WIKIA_ENV_PREVIEW
 * Name constant for "preview" environment.
 * @deprecated Code portability: do not add more environment-specific code.
 */
define( 'WIKIA_ENV_PREVIEW', 'preview' );

/**
 * @name WIKIA_ENV_PROD
 * Name constant for "prod" environment.
 * @deprecated Code portability: do not add more environment-specific code.
 */
define( 'WIKIA_ENV_PROD', 'prod' );

/**
 * @name WIKIA_ENV_SANDBOX
 * Name constant for "sandbox" environment.
 * @deprecated Code portability: do not add more environment-specific code.
 */
define( 'WIKIA_ENV_SANDBOX', 'sandbox' );

/**
 * @name WIKIA_ENV_VERIFY
 * Name constant for "verify" environment.
 * @deprecated Code portability: do not add more environment-specific code.
 */
define( 'WIKIA_ENV_VERIFY', 'verify' );

/**
 *  CONFIG_REVISION: The old contents of the file follows.
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

// Any types listed in this array will not have their values serialized
// This should only be used for properties that are simple strings or integers
$wgWPPNotSerialized = array( WPP_LYRICFIND_MARKED_FOR_REMOVAL, WPP_VIDEO_STATUS );

define( 'PREFERENCE_EDITOR', 'editor' );

/**
 * Should Magpie cache parsed RSS objects?s
 * @see extensions/3rdparty/RSS/magpierss/rss_fetch.inc
 */
define('MAGPIE_CACHE_ON', false);

/**
 * Magpie read timeout in seconds.
 * @see extensions/3rdparty/RSS/magpierss/rss_fetch.inc
 */
define('MAGPIE_FETCH_TIME_OUT', 20);
