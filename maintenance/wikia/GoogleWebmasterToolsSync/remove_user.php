<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/remove_user.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php -u example@gmail.com

$optionsWithArgs = array( 'u' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	if( !isset($options['u']) ) {
		GWTLogHelper::error( "Specify email (-u)" );
		die(1);
	}

	$userRepository = new GWTUserRepository();

	$userRepository->deleteByEmail( $options['u'] );

	GWTLogHelper::notice( __FILE__ . " script end.");
} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
