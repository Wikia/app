<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * clear wikifactory variables cache
 *
 * Usage:
 * (particular wiki)
 * SERVER_ID=<city_id_from_city_list> php maintenance/wikia/clear_wikifactory_cache.php
 *
 * or
 * (whole cache, all wikis)
 * SERVER_ID=177 php maintenance/wikia/clear_wikifactory_cache.php --all
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


$all = isset( $options[ "all" ] ) ? $options[ "all" ] : false;

if ( ! $all ) {
	WikiFactory::clearCache( $wgCityId );
	printf("%s removing %5d:%s from cache\n", wfTimestamp( TS_DB, time() ), $wgCityId, $wgDBname );
}
else {
	/**
	 * iterate through city_list
	 */
	$dbr = wfGetDB( DB_SLAVE );

	$res = $dbr->select(
		wfSharedTable( "city_list" ),
		array( "city_id", "city_dbname" ),
		array( "city_public"  => 1 ),
		__FILE__,
		array( "ORDER BY" => "city_id" )
	);

	while ( $row = $dbr->fetchObject( $res ) ) {
		WikiFactory::clearCache( $row->city_id );
		printf("%s removing %5d:%s from cache\n", wfTimestamp( TS_DB, time() ), $row->city_id, $row->city_dbname  );
	}
	$dbr->close();
}
