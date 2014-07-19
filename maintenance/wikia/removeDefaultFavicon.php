<?php
/**
 * @author: Christian, Inez
 *
 * Get familiar with "How_to_run_maintenance_script" article on internal to figure out how to run it.
 */
ini_set( "include_path", dirname(__FILE__)."/../" );
require_once( "commandLine.inc" );

// Skip community wiki
if ( $wgCityId == WikiFactory::COMMUNITY_CENTRAL ) {
	exit();
}

$faviconTitle = Title::newFromText( 'Favicon.ico', NS_FILE );

// We need to check existance of the title, not just file file due to VID-1744
if ( $faviconTitle->exists() ) {

	$faviconFile = wfFindFile('Favicon.ico');

	// If the file exists and there is no history, there is only a single version of the favicon.
	if ( $faviconFile->exists() && !$faviconFile->getHistory() ) {

		// Get some timestamps.
		$dbr = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$wikiTimestamp = strtotime( $dbr->selectField( 'city_list', 'city_created', ['city_id' => $wgCityId] ) );
		$faviconTimestamp = strtotime( $faviconFile->getTimestamp() );

		// If the favicon was created within 1 minute of the wiki being created, delete the image.
		if ( abs( $faviconTimestamp - $wikiTimestamp ) < 60 ) {
			//$faviconFile->delete( "Redundant favicon." );
		}
	}
}
