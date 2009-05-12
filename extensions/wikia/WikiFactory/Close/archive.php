<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

$city_id = isset( $options[ "city_id" ] ) ? $options[ "city_id" ] : false;
if( $city_id ) {
	WikiFactory::copyToArchive( $city_id );
}
else {
	print "Usage: archive.php --city_id <city_id>\n";
}
