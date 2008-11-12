<?php

ini_set( "include_path", dirname(__FILE__)."/../" );

if ( !defined( 'MEDIAWIKI' ) ) {

	require_once( dirname(__FILE__) . '/../commandLine.inc' );
	require_once( 'ExternalStoreDB.php' );
	syncRevsWithBlobs();
}



function syncRevsWithBlobs( ) {
	global $wgCityId;

	$fname = __METHOD__;
	$dbw = wfGetDB( DB_MASTER );
	$dbr = wfGetDB( DB_SLAVE );

	$ext = new ExternalStoreDB;
	$numMoved = 0;
	$numStubs = 0;

	$res = $dbr->query(
		"SELECT * FROM revision r1 FORCE INDEX (PRIMARY), text t2, page
		WHERE old_id = rev_text_id
		AND rev_page = page_id
		AND old_flags LIKE '%external%'
		ORDER BY rev_timestamp, rev_id",
		$fname
	);
	$dbrExt = wfGetDBExt( DB_SLAVE );

	while ( $row = $dbr->fetchObject( $res ) ) {
#		print_r( $row );
		$url = $row->old_text;

		list( $store, $host, $cluster, $id ) = explode( "/", $url );

		$blob = $dbrExt->selectRow(
			array( "blobs" ),
			array( "*" ),
			array( "blob_id" => $id ),
			__METHOD__
		);
		$update = array();
		if( isset( $blob->blob_id ) ) {
			/**
			 * compare things from revisions with blobs
			 */
			if( $row->rev_id != $blob->rev_id) {
				$update[ "rev_id" ] = $row->rev_id;
			}
			if( $row->page_id != $blob->rev_page_id ) {
				$update[ "rev_page_id" ] = $row->page_id;
			}
			if( $row->page_namespace != $blob->rev_namespace ) {
				$update[ "rev_namespace" ] = $row->page_namepace;
			}
			if( $row->old_flags != $blob->rev_flags ) {
				$update[ "rev_flags" ] = $row->old_flags;
			}
			if( $row->rev_timestamp != $blob->rev_timestamp ) {
				$update[ "rev_timestamp" ] = $row->rev_timestamp;
			}

			print_r( $update );
		}
		$numMoved++;
	}
	$dbr->freeResult( $res );
}
/**
    [blob_id] => 6
    [rev_wikia_id] => 165
    [rev_id] => 5090
    [rev_page_id] => 2425
    [rev_namespace] => 501
    [rev_user] => 51098
    [rev_user_text] => Eloy.wikia
    [rev_timestamp] => 2008-11-07 13:13:19
    [blob_text] => KT(�W�J-.Q�JT(�L-J��,	T%W�*d��U*d�����$U
    [rev_flags] => utf-8,gzip,external
    [rev_ip] => 0
 **/
