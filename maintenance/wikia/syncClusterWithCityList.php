<?php

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbw = WikiFactory::db( DB_MASTER );

$sth = $dbw->select(
	array( "city_list" ),
	array( "*" ),
	array( "city_public" => 1 ),
	__METHOD__,
	array( "ORDER BY" => "city_id" )
);

while( $row = $dbw->fetchObject( $sth ) ) {
	/**
	 * get cluster
	 */
	$cluster = WikiFactory::getVarValueByName( "wgDBcluster", $row->city_id );
	if( $cluster !== $row->city_cluster ) {
		Wikia::log( __FILE__, false, "Difference in {$row->city_id}: {$cluster} vs. {$row->city_cluster}" );
	}
}
