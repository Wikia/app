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
 * Defines for Forum namespace
 */
define('NS_FORUM', 110);
define('NS_FORUM_TALK', 111);


/*
 * wikia page props type 
 *
 */

define( "WPP_IMAGE_SERVING", 0 );
define( "WPP_PLB_PROPS", 1 );
define( "WPP_PLB_LAYOUT_DELETE", 2);
define( "WPP_PLB_LAYOUT_NOT_PUBLISH", 3);