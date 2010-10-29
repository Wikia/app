<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 * @author eloy@wikia
 *
 * change user_options entry for skin from monaco to oasis
 *
 */

$optionsWithArgs = array( 'rev-from', 'rev-to' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbr = wfGetDB( DB_SLAVE );

$riak = new ExternalStoreRiak;
$condition = "";
if( $options[ "rev-from" ] && $options[ "rev-to"] ) {
	$condition = sprintf("AND rev_id BETWEEN %d AND %d", $options[ "rev-from" ], $options[ "rev-to" ]);
}
elseif( $options[ "rev-from" ] && !$options[ "rev-to"] ) {
	$condition = sprintf("AND rev_id > %d", $options[ "rev-from" ] );
}
elseif( !$options[ "rev-from" ] && $options[ "rev-to"] ) {
	$condition = sprintf("AND rev_id < %d", $options[ "rev-to" ] );
}

$sql = "SELECT * FROM revision r1 FORCE INDEX (PRIMARY), text t2 WHERE old_id = rev_text_id $condition ORDER BY rev_id";
echo $sql . "\n";

$sth = $dbr->query( $sql );
$c = 0;

while( $row = $dbr->fetchObject( $sth ) ) {
	/**
	 * get only external revisions
	 */
	if( strpos( $row->old_flags, "external" ) !== false ) {
		$t = microtime( true );
		$text = ExternalStore::fetchFromURL( $row->old_text );
		$t = microtime( true ) - $t;
		echo "Getting blobs from db, time={$t}\n";
		if( $text ) {
			$t = microtime( true );
			$key = sprintf( "%d:%d:%d", $wgCityId, $row->rev_page, $row->rev_id );
			$riak->storeBlob( $key, $text );
			$t = microtime( true ) - $t;
			$c++;
			echo "Moving from db to riak with key $key, time={$t}\n";
		}
	}
}
echo "Moved $c blobs to riak\n";
