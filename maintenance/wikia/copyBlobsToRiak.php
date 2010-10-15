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
while( $row = $dbr->fetchObject( $sth ) ) {
	/**
	 * get only external revisions
	 */
	if( strpos( $row->old_flags, "external" ) !== false ) {
		$text = ExternalStore::fetchFromURL( $row->old_text );
	}
	$key = sprintf( "%d:%d:%d", $wgCityId, $row->rev_page, $row->rev_id );
	echo "Moving from db to riak with key $key\n";
	$riak->storeBlob( $key, $text );
}
