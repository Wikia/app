<?php

ini_set( "include_path", dirname(__FILE__)."/../" );

if ( !defined( 'MEDIAWIKI' ) ) {

	require_once( dirname(__FILE__) . '/../commandLine.inc' );
}

$dbw = WikiFactory::db( DB_MASTER );

$sth = $dbw->select(
	array( "city_list" ),
	array( "city_dbname", "city_id" ),
	array( "city_public" => 1, "city_created" => '0000-00-00 00:00:00' ),
	__METHOD__
);

while( $row = $dbw->fetchObject( $sth ) ) {
	$dbr = wfGetDB( DB_SLAVE, array(), $row->city_dbname );
	$rev = $dbr->selectRow(
		array( "revision" ),
		array( "rev_timestamp" ),
		array( "rev_timestamp <> 0" ),
		__CLASS__,
		array( "ORDER BY" => "rev_timestamp" )
	);
	$t = wfTimestamp( TS_DB, $rev->rev_timestamp );
	$dbw->update( "city_list", array( "city_created" => $t  ), 
		      array( "city_id" => $row->city_id ) );
	echo "{$row->city_id} updated to {$t}\n";
}
