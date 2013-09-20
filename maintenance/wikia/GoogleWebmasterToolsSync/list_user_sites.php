<?php

$optionsWithArgs = array( 'u' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	$userRepository = new GWTUserRepository();

	if( !isset($options['u']) ) {
		GWTLogHelper::error( "Specify user (-u)." );
		die(1);
	}

	$user = $userRepository->getByEmail( $options['u'] );
	if( $user == null ) {
		GWTLogHelper::error( "No such user. Try add_user.php." );
		die(1);
	}
	$util = new WebmasterToolsUtil();
	$sites = $util->getSites( $user );
	foreach( $sites as $i => $s ) {
		echo $s->getUrl() . " " . $s->getVerified() . "\n";
	}

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
