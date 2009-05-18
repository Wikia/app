<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

/**
 * compare values stored in city_list and city_variables
 */

$dbr = wfGetDB( DB_SLAVE );
$sth = $dbr->select(
	WikiFactory::table("city_list"),
	array( "city_dbname", "city_id", "city_public" ),
	false,
	__FILE__,
	array( "ORDER BY" => "city_id" )
);

while( $row = $dbr->fetchObject( $sth ) ) {
	$variable = $dbr->selectRow(
		WikiFactory::table( "city_variables" ),
		array( "cv_value" ),
		array(
			"cv_city_id" => $row->city_id,
			"cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name='wgDBname')"
		),
		__FILE__
	);

	if( !empty( $variable->cv_value ) ) {
		if( unserialize( $variable->cv_value ) !== $row->city_dbname ) {
			print "wgDBname different than city_dbname in city_id={$row->city_id} city_public={$row->city_public}\n";
		}
		else {
			/**
			 * check if such database exists
			 */
			$exists = $dbr->selectRow(
				array( "INFORMATION_SCHEMA.SCHEMATA" ),
 				array( "count(SCHEMA_NAME) as count" ),
				array( "SCHEMA_NAME" => $row->city_dbname ),
				__FILE__
			);
			if( !$exists->count ) {
				print "city_dbname={$row->city_dbname} defined but not exists for city_id={$row->city_id} city_public={$row->city_public}\n";
			}
		}
	}
	else {
		print "wgDBname is not defined in city_id={$row->city_id} city_public={$row->city_public}\n";
	}
}
