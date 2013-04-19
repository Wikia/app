<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 15:52
 */

$optionsWithArgs = array( 'i' );

require_once( __DIR__."/configure_log_file.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");

try {
	if( !isset($options['i']) ) {
		GWTLogHelper::error( "Specify wiki id ( city_id ) (-i)" );
	}

	$service = new GWTService();
	$wiki = $service->getWikiRepository()->oneByWikiId( $options['i'] );
	if( !$wiki ) {
		GWTLogHelper::error( "No wiki for " . $options['i'] . "\n" );
		die();
	}
	if( !$wiki->getUserId() ) {
		GWTLogHelper::error( "User id empty for " . $wiki->getWikiId() . "\n" );
		die();
	}
	$user = $service->getUserRepository()->getById( $wiki->getUserId() );
	$info = $service->verifyWiki( $wiki, $user );
	var_dump($info);

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
