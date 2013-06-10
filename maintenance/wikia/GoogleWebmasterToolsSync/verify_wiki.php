<?php

$optionsWithArgs = array( 'i' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");

try {
	if( !isset($options['i']) ) {
		GWTLogHelper::error( "Specify wiki id ( city_id ) (-i)" );
		die(1);
	}

	$service = new GWTService();
	$wiki = $service->getWikiRepository()->getById( $options['i'] );
	if( !$wiki ) {
		GWTLogHelper::error( "No wiki for " . $options['i'] . "\n" );
		die(1);
	}
	if( !$wiki->getUserId() ) {
		GWTLogHelper::error( "User id empty for " . $wiki->getWikiId() . "\n" );
		die(1);
	}
	$user = $service->getUserRepository()->getById( $wiki->getUserId() );
	$info = $service->verifyWiki( $wiki, $user );
	GWTLogHelper::notice( __FILE__ . " script ends.");

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
