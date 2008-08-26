<?php

ini_set( "include_path", dirname(__FILE__)."/../" );

if ( !defined( 'MEDIAWIKI' ) ) {
	$optionsWithArgs = array( 'limit' );

	require_once( dirname(__FILE__) . '/../commandLine.inc' );
	require_once( 'ExternalStoreDB.php' );
	require_once( 'maintenance/storage/resolveStubs.php' );

	$fname = 'moveToExternal';
	$limit = isset( $options[ "limit" ] ) ? $options[ "limit" ] : false;

	if ( !isset( $args[0] ) ) {
		print "Usage: php moveToExternal.php <cluster>\n";
		exit;
	}

	$cluster = $args[0];
	moveToExternal( $cluster, $limit );
}



function moveToExternal( $cluster, $limit ) {
	$fname = 'moveToExternal';
	$dbw = wfGetDB( DB_MASTER );
	$dbr = wfGetDB( DB_SLAVE );

	$ext = new ExternalStoreDB;
	$numMoved = 0;
	$numStubs = 0;
	$limit =  ( $limit !== false) ? "LIMIT $limit" : "";

	$sql = "SELECT * FROM revision r1 FORCE INDEX (PRIMARY), text t2
		WHERE old_id = rev_text_id
		AND old_flags NOT LIKE '%external%'
		AND old_text NOT LIKE '%HistoryBlobStub%'
		ORDER BY rev_id DESC
		$limit";

	$res = $dbr->query( $sql, __METHOD__ );
	echo $sql."\n";
	$ext = new ExternalStoreDB;
	echo "Get external storage object\n";
	while ( $row = $dbr->fetchObject( $res ) ) {
		$text = $row->old_text;
		$id = $row->old_id;
#		echo $row->rev_id.":".$row->old_flags."\n";
		if ( $row->old_flags === '' ) {
			$flags = 'external';
		} else {
			$flags = "{$row->old_flags},external";
		}

		if ( strpos( $flags, 'object' ) !== false ) {
			$obj = unserialize( $text );
			$className = strtolower( get_class( $obj ) );
			if ( $className == 'historyblobstub' ) {
				#resolveStub( $id, $row->old_text, $row->old_flags );
				#$numStubs++;
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

		$url = $ext->store( $cluster, $text );
		if ( !$url ) {
			print "Error writing to external storage\n";
			exit;
		}

		$dbw->update(
			'text',
			array( 'old_flags' => $flags, 'old_text' => $url ),
			array( 'old_id' => $id ),
			$fname
		);

		$revision = Revision::newFromId( $row->rev_id );
		if( $revision ) {
			$extUpdate = new ExternalStorageUpdate( $url, $revision, $flags );
			$extUpdate->doUpdate();
		}
		else {
			echo "Cannot load revision by id = {$row->rev_id}\n";
		}

		$lag = $dbr->getLag();
		printf("%s storing %8d bytes at %s, old_id =%8d\n", wfTimestamp( TS_DB, time() ), strlen( $text ), $url, $id );
		if( $lag > 4 ) {
			printf("%s lag: {$lag}. waiting...\n", wfTimestamp( TS_DB, time() ) );
			sleep( floor( $lag ) );
		}

		$numMoved++;
	}
	$dbr->freeResult( $res );
}
