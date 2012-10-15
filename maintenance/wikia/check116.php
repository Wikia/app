<?php

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbr = WikiFactory::db( DB_SLAVE );

$sth = $dbr->select(
	array( "city_list" ),
	array( "city_dbname", "city_id" ),
	array( "city_public" => 1, "city_cluster" => "c3" ),
	__METHOD__
);

while( $row = $dbr->fetchObject( $sth ) ) {
	if( $row->city_id == 177 ) {
		continue;
	}

	$dbc = wfGetDB( DB_SLAVE, array( ), $row->city_dbname );
#	echo "{$row->city_id} {$row->city_dbname}\n";
	if( ! $dbc->fieldExists( "logging", "log_user_text" ) ) {
		echo "$row->city_id\n";
	}
	$dbc->close();
}
