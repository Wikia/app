<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * change user_options entry for skin from monaco to oasis
 *
 */

$optionsWithArgs = array( 'page-from', 'page-to', 'target' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbr = wfGetDB( DB_SLAVE );

$riak = new ExternalStoreRiak;

$sth = $dbr->query( "SELECT * FROM revision r1 FORCE INDEX (PRIMARY), text t2 WHERE old_id = rev_text_id" );
$c = 0;

while( $row = $dbr->fetchObject( $sth ) ) {
	/**
	 * get only external revisions
	 */
	if( strpos( $row->old_flags, "external" ) !== false ) {
		$t = microtime( true );
		$text = ExternalStore::fetchFromURL( $row->old_text );
		$t = microtime( true ) - $t;
		$t = microtime( true );
		echo "Getting blobs from db, time={$t}\n";
		if( $text ) {
			$key = sprintf( "%d:%d:%d", $wgCityId, $row->rev_page, $row->rev_id );
			$riak->storeBlob( $key, $text );
			$t = microtime( true ) - $t;
			$c++;
			echo "Moving from db to riak with key $key, time={$t}\n";
		}
	}
}
echo "Moved $c blobs to riak\n";
