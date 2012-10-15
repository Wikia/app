<?php

ini_set( "include_path", dirname(__FILE__)."/../" );

if ( !defined( 'MEDIAWIKI' ) ) {

	require_once( dirname(__FILE__) . '/../commandLine.inc' );
	require_once( 'ExternalStoreDB.php' );
	moveToExternal();
}



function moveToExternal( ) {
	$fname = __METHOD__;
	$dbw = wfGetDB( DB_MASTER );
	$dbr = wfGetDB( DB_SLAVE );

	$ext = new ExternalStoreDB;
	$numMoved = 0;
	$numStubs = 0;

	$res = $dbr->query(
		"SELECT * FROM revision r1 FORCE INDEX (PRIMARY), text t2
		WHERE old_id = rev_text_id
		AND old_flags LIKE '%external%'
		ORDER BY rev_timestamp, rev_id",
		$fname
	);
	$ext = new ExternalStoreDB;

	while ( $row = $dbr->fetchObject( $res ) ) {
		$url = $row->old_text;
		$id = $row->old_id;

		/**
		 * do the trick with spliiting string and rejoining without external
		 * flag
		 */
		$flags = explode(",", $row->old_flags );
		$ftmp = array();
		foreach( $flags as $f ) {
			$f = trim( $f );
			if( $f === "external" ) {
				continue;
			}
			$ftmp[] = $f;
		}
		$flags = implode(",", $ftmp );

		if ( strpos( $flags, 'object' ) !== false ) {
			$obj = unserialize( $text );
			$className = strtolower( get_class( $obj ) );
			if ( $className == 'historyblobstub' ) {
				continue;
			} elseif ( $className == 'historyblobcurstub' ) {
				$text = gzdeflate( $obj->getText() );
				$flags = 'utf-8,gzip,external';
			} elseif ( $className == 'concatenatedgziphistoryblob' ) {
				// Do nothing
			} else {
				print "Warning: unrecognised object class \"$className\"\n";
				continue;
			}
		} else {
			$className = false;
		}

		$text = ExternalStore::fetchFromURL( $url );
		echo "moved url {$url} back to {$id} with flags {$flags}\n";

		$dbw->update(
			'text',
			array( 'old_flags' => $flags, 'old_text' => $text ),
			array( 'old_id' => $id ),
			$fname
		);
		$numMoved++;
	}
	$dbr->freeResult( $res );
}
