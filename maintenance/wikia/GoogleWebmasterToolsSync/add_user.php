<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/add_user.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php -u u2 -p pass

$optionsWithArgs = array( 'u', 'p' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	if( !isset($options['u']) || !isset($options['p']) ) {
		GWTLogHelper::warning( "Specify user (-u) and password (-p)" );
		die();
	}

	$userRepository = new GWTUserRepository();

	$r = $userRepository->create( $options['u'], $options['p'] );
	if ( $r == null ) {
		GWTLogHelper::warning( "error while inserting user." );
		die();
	}
	GWTLogHelper::notice( $r->getId() . " " . $r->getEmail() . "\n" );

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
