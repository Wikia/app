<?php

$optionsWithArgs = array( 'i' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	if( !isset($options['i']) ) {
		echo "Specify wikiid (-i)";
	}

	$wikiRepository = new GWTWikiRepository();

	$user = $wikiRepository->create( $options['i'] );
	var_dump($user);

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
