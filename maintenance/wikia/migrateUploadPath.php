<?php
/**
 * GlobalWatchlistBot execute script - part of GlobalWatchlist extension
 *
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once('commandLine.inc');

/**
 * connect to WF db
 */
$dbr = Wikifactory::db( DB_MASTER );
$sth = $dbr->select(
		array( "city_variables" ),
		array( "*" ),
		array( "cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name = 'wgUploadDirectory')"),
		__METHOD__
);
while( $row = $dbr->fetchObject( $sth ) ) {
	$value = ltrim( unserialize( $row->cv_value ), "/" );
	$parts = explode( "/", $value );
	/**
	 * first part is not interesting
	 */
	$prefix = array_shift( $parts );
	if( strlen( $parts[0] ) > 1 ) {
		/*
		 * it's not converted yet
		 */
		$letter = strtolower( substr( $parts[ 0 ], 0, 1) );
		$path = sprintf( "/%s/%s/%s", $prefix, $letter, implode( "/", $parts ) );
		print "{$value} => {$path}\n";
		/**
		 * now update value through WF to get logs
		 */
		WikiFactory::setVarByName( "wgUploadPath", $row->cv_city_id, $path );
	}
}
