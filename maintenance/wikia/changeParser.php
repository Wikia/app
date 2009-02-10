<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


$cities = array();

foreach( $cities as $city_id ) {
	WikiFactory::setVarByName( "wgEnableNewParser", $city_id, true );
	WikiFactory::clearCache( $city_id );
}
