<?php


$optionsWithArgs = array( 'i' );

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");

try {
	if( !isset($options['i']) ) {
		GWTLogHelper::error( "Specify wiki id (-i)" );
		die();
	}

	$service = new GWTService();
	GWTLogHelper::notice("wiki_id: " . $options["i"] );
	$wiki = $service->getWikiRepository()->getById( $options['i'] );
	if( !$wiki ) {
		GWTLogHelper::error( "No wiki for " . $options['i'] . "\n" );
		die(1);
	}
	if( !$wiki->getUserId() ) {
		GWTLogHelper::error( "User id empty for " . $wiki->getWikiId() . "\n" );
		die(1);
	}
	GWTLogHelper::notice("user_id: " . $wiki->getUserId() );
	$user = $service->getUserRepository()->getById( $wiki->getUserId() );
	GWTLogHelper::notice("email  : " . $user->getEmail() );
	$info = $service->sendSitemap( $wiki, $user );
	GWTLogHelper::notice( __FILE__ . " script end.");

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
