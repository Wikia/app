<?php

$optionsWithArgs = array( 'i' );

require_once( __DIR__."/configure_log_file.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	if( !isset($options['i']) ) {
		GWTLogHelper::error( "Specify wikiid (-i)" );
		die(1);
	}

	$service = new GWTService();
	$info = $service->getWikiInfo( $options['i'] );
	var_dump($info);

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
