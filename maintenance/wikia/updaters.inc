<?php
/**
 * Wikia-specific updaters
 *
 * @file
 * @ingroup Maintenance
 */

/* not needed: wikicities.ad_slot_override, ad_provider_value */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is not a valid entry point\n";
	exit( 1 );
}

$wgUpdates[ "mysql" ][] = array( "add_table", "page_vote",  "wikia/patch-create-page_vote.sql" );
$wgUpdates[ "mysql" ][] = array( "add_table", "page_visited",  "wikia/patch-create-page_visited.sql" );
$wgUpdates[ "mysql" ][] = array( "add_field", "watchlist", "wl_wikia_addedtimestamp", "wikia/patch-watchlist-improvements.sql" );
$wgUpdates[ "mysql" ][] = array( "add_table", "blog_listing_relation",  "wikia/patch-create-blog_listing_relation.sql" );
$wgUpdates[ "mysql" ][] = array( "add_index", "archive", "page_revision", "wikia/patch-index-archive-page_revision.sql" );
$wgUpdates[ "mysql" ][] = array( "add_table", "page_wikia_props",  "$IP/extensions/wikia/ImageServing/sql/table.sql", true );
$wgUpdates[ "mysql" ][] = array( "do_page_vote_unique_update" );
$wgUpdates[ "mysql" ][] = array( "do_page_wikia_props_update" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "imagetags" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "send_queue" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "send_stats" );
$wgUpdates[ "mysql" ][] = array( "do_drop_table", "searchindex" );


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

function do_page_wikia_props_update() {
	global $wgDatabase;
	wfOut( "Checking wikia page_wikia_props table...\n" );
	if( $wgDatabase->tableExists( "page_wikia_props" ) ) {
		$tableInfo = $wgDatabase->fieldInfo( "page_wikia_props", "propname" );
		if( $tableInfo->type() === "string" ) {
			/**
			 * remove duplicates
			 */
			//
			$sth = $wgDatabase->query( "SELECT page_id FROM page_wikia_props GROUP BY page_id HAVING count(*) > 1", __METHOD__ );
			wfOut( "... removing duplicates first: " );
			$dups = 0;
			while( $row = $wgDatabase->fetchObject( $sth ) ) {
				$wgDatabase->delete( "DELETE FROM page_wikia_props WHERE page_id = {$row->page_id} AND propname = 'imageOrder'" );
				$dups++;
			}
			wfOut( "{$dups}\n" );
			$wgDatabase->query( "ALTER TABLE page_wikia_props CHANGE  propname propname INT(10) NOT NULL", __METHOD__ );
			wfOut( "... altered to integer.\n" );
		}
		else {
			wfOut( "... already altered to integer.\n" );
		}
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

/**
 * @author
 * updaters for shared database ie.
 * - WikiFactory tables
 * - shared extensions tables
 *
 * look at examples
 */
global $wgDBname, $wgExternalSharedDB;

if( $wgDBname === $wgExternalSharedDB ) {
	$wgUpdates[ "mysql" ][] = array( "add_table", "city_list",  "wikia/wf/patch-create-city_list.sql" );
	$wgUpdates[ "mysql" ][] = array( "add_table", "city_cats",  "wikia/wf/patch-create-city_cats.sql" );
}
