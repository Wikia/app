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

$wgUpdates[ "mysql" ][] = array( "add_field", "watchlist", "wl_wikia_addedtimestamp", "wikia/patch-watchlist-improvements.sql" );
$wgUpdates[ "mysql" ][] = array( "add_table", "blog_listing_relation",  "wikia/patch-create-blog_listing_relation.sql" );


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

