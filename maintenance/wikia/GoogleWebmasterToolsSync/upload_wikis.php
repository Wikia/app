<?php
global $IP;

$optionsWithArgs = array( 'm' );

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');
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
	echo "Synchronizing: " . $wiki->getWikiId() . " " . $users[$userI]->getEmail() .  "\n";
	try {
		$service->uploadWikiAsUser( $wiki, $users[$userI] );
		$service->verifyWiki( $wiki, $users[$userI] );
	} catch ( Exception $e ) {
		echo "Error while synchronizing " . $wiki->getWikiId() . " " . $users[$userI]->getEmail() .  "\n";
		echo "" . $e->getMessage() . "\n";
	}
}
