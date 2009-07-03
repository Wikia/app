<?php
/**
 * migrateUploadPath -- migrate images to new directory layout
 *
 * @addto maintenance
 * @author Krzysztof Krzyżaniak (eloy)
 *
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once('commandLine.inc');

/**
 * connect to WF db
 */
$variable = "wgServer";
$dbw = Wikifactory::db( DB_MASTER );
$sth = $dbw->select(
		array( "city_variables" ),
		array( "*" ),
		array( "cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name = '{$variable}')"),
		__METHOD__,
		array( "FOR UPDATE" )
);
while( $row = $dbw->fetchObject( $sth ) ) {

	$before = unserialize( $row->cv_value );
	$after  = rtrim( $before, "/" );
	if( $before !== $after ) {
		print "{$before} <> {$after}\n";
#		WikiFactory::setVarByName( $variable, $row->cv_city_id, $after );
#		WikiFactory::clearCache( $row->cv_city_id );
	}
}
