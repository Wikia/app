<?php

ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( 'commandLine.inc' );

function countNotExternal() {

	$dbr = wfGetDB( DB_SLAVE, "dpl" );
	/**
	 * get active databases from city_list
	 */
	$databases = array();
	$res = $dbr->select(
		wfSharedTable( "city_list" ),
		array( "city_dbname" ),
		array( "city_public" => 1 ),
		__FUNCTION__
	);
	while( $row = $dbr->fetchObject( $res ) ) {
		$databases[] = $row->city_dbname;
	}
	$dbr->freeResult( $res );

	foreach( $databases as $database )  {

		$sql = "
			SELECT count(*) as count
			FROM revision r1 FORCE INDEX (PRIMARY), text t2
			WHERE old_id = rev_text_id
			AND old_flags NOT LIKE '%external%'
		";
		$dbr->selectDB( $database );
		$dbr->begin();
		$res = $dbr->query( $sql, __FUNCTION__ );
		$row = $dbr->fetchObject( $res );

		if( !empty( $row->count ) ) {
			printf( "Not External rows in %20s = %8d\n", $database, $row->count );
		}

		$dbr->freeResult( $res );
		$dbr->commit();
	}
}

countNotExternal();
