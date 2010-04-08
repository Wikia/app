<?php

ini_set( "include_path", dirname(__FILE__)."/../" );

if ( !defined( 'MEDIAWIKI' ) ) {

	require_once( dirname(__FILE__) . '/../commandLine.inc' );
}

$dbw = WikiFactory::db( DB_MASTER );

$sth = $dbw->select(
	array( "city_list" ),
	array( "city_dbname" ),
	array( "city_public" => 1, "city_created" => '0000-00-00 00:00:00' ),
	__METHOD__
);

while( $row = $dbw->fetchObject( $sth ) ) {
	$dbr = wfGetDB( DB_SLAVE, array(), $row->city_dbname );
	$row = $dbr->selectRow(
		array( "revision" ),
		array( "rev_timestamp" ),
		false,
		__CLASS__,
		array( "ORDER BY" => "rev_timestamp" )
	);
	print wfTimestamp( MW_DB, $row->rev_timestamp );
}
