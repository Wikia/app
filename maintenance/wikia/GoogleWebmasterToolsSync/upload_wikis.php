<?php
global $IP;

$optionsWithArgs = array( 'm' );

require_once( __DIR__."/configure_log_file.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	$max_wikis_to_sync = 10;

	if( isset( $options['m'] ) ) {
		$max_wikis_to_sync = intval( $options['m'] );
	}

	$service = new GWTService();

	$users = $service->getAvailableUsers();
	$wikis = $service->getWikisToUpload();

	$userI = 0;
	foreach ( $wikis as $i => $wiki ) {
		if( $i >= $max_wikis_to_sync ) break;
		if( $users[$userI]->getCount() >= $service->getMaxSitesPerAccount() ) {
			$service->getUserRepository()->update( $users[$userI] );
			$userI ++;
		}
		if( $userI >= count( $users ) ) {
			break;
		}
		GWTLogHelper::notice( "Synchronizing: " . $wiki->getWikiId() . " " . $users[$userI]->getEmail() );
		try {
			$service->uploadWikiAsUser( $wiki, $users[$userI] );
			$service->verifyWiki( $wiki, $users[$userI] );
			$service->sendSitemap( $wiki, $users[$userI] );
		} catch ( Exception $e ) {
			GWTLogHelper::error( "Error while synchronizing " . $wiki->getWikiId() . " " . $users[$userI]->getEmail() );
			GWTLogHelper::error( "" . $e->getMessage() );
		}
	}

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
