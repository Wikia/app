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

$wgUpdates[ "mysql" ][] = array( "add_table", "page_vote",  "wikia/patch-create-page_vote.sql" );
$wgUpdates[ "mysql" ][] = array( "add_table", "page_visited",  "wikia/patch-create-page_visited.sql" );
$wgUpdates[ "mysql" ][] = array( "add_field", "watchlist", "wl_wikia_addedtimestamp", "wikia/patch-watchlist-improvements.sql" );
$wgUpdates[ "mysql" ][] = array( "add_table", "blog_listing_relation",  "wikia/patch-create-blog_listing_relation.sql" );
$wgUpdates[ "mysql" ][] = array( "add_index", "archive", "page_revision", "wikia/patch-index-archive-page_revision.sql" );
$wgUpdates[ "mysql" ][] = array( "do_page_vote_unique_update" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "imagetags" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "send_queue" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "send_stats" );


/**
 * @todo drop send_stats shared/send_queue
 */

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

/**
 * there's no big logic in dropping tables so we don't use patches here
 */
function do_drop_table( $table ) {
	global $wgDatabase;
	wfOut( "Checking wikia $table table...\n" );
	if( $wgDatabase->tableExists( $table ) ) {
		wfOut( "...dropping $table table... " );
		$wgDatabase->query( "DROP TABLE {$table}" );
        wfOut( "ok\n" );
	}
}
