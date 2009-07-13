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
		    array( "city_variables", "city_list" ),
		array( "*" ),
		array(
			"cv_variable_id = (SELECT cv_id FROM city_variables_pool WHERE cv_name = '{$variable}')",
			"city_public=1",
			"city_id = cv_city_id"
		),
		__METHOD__
);
while( $row = $dbw->fetchObject( $sth ) ) {
	$before = unserialize( $row->cv_value );

	$parts = explode( "/", $before );
	array_shift( $parts ); array_shift( $parts );
	$domain = array_shift( $parts );

	$match = $dbw->selectRow(
		array( "city_domains" ),
		array( "count(*) as count" ),
		array(
			"city_id" => $row->cv_city_id,
			"city_domain" => $domain
		),
		__METHOD__
	);

	if( empty( $match->count ) ) {
		print "{$row->cv_city_id} {$before} is wrong ";
		$parts = explode( ".", $domain );
		$tmp = $parts[ 0 ];
		$parts[ 0 ] = $parts[ 1 ];
		$parts[ 1 ] = $tmp;
		$after = implode( ".", $parts );
		$after = "http://" . $after;
		print "it should be {$after}\n";
#		WikiFactory::setVarByName( $variable, $row->cv_city_id, $after );
#		WikiFactory::clearCache( $row->city_id );
	}
}
