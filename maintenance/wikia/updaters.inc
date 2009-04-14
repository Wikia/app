<?php
/**
 * Wikia-specific updaters
 *
 * @file
 * @ingroup Maintenance
 */


if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is not a valid entry point\n";
	exit( 1 );
}

$wgMysqlUpdates[] = array( "do_page_vote_unique_update" );

function do_page_vote_unique_update() {
	global $wgDatabase;
	wfOut( "Checking wikia page_vote table...\n" );
	if( $wgDatabase->indexExists( 'page_vote', 'unique_vote' ) ) {
		wfOut( "...page_vote unique key already set.\n" );
	} else {
		wfOut( "Making page_vote unique key... " );
		dbsource( archive("wikia/patch-page_vote_unique_vote.sql"), $wgDatabase );
		wfOut( "ok\n" );
	}
}
