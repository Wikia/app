<?php

$optionsWithArgs = array( 'u', 'w' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	if( !isset($options['u']) || !isset($options['w']) ) {
		GWTLogHelper::error( "Specify user (-u) and wikiId (-p)" );
		die(1);
	}

	$userRepository = new GWTUserRepository();
	$wikiRepository = new GWTWikiRepository();
	$service = new GWTService($userRepository, $wikiRepository);

	$u = $userRepository->getByEmail( $options['u'] );
	$w = $wikiRepository->getById( $options['w']);

	if ( $u == null && $w == null ) {
		GWTLogHelper::error( "no user or no wiki." );
		die( 1 );
	}
	$service->uploadWikiAsUser( $w, $u );

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
