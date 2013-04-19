<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 14:28
 */

$optionsWithArgs = array( 'u', 'w' );

require_once( __DIR__."/configure_log_file.php" );
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
	$w = $wikiRepository->oneByWikiId( $options['w']);

	if ( $u == null && $w == null ) {
		GWTLogHelper::error( "no user or no wiki." );
		die( 1 );
	}
	$result = $service->uploadWikiAsUser( $w, $u );
	var_dump($result);

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
