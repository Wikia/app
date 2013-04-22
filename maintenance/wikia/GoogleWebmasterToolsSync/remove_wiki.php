<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/remove_wiki.php  --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php -i 652441

$optionsWithArgs = array( 'i' );

require_once( __DIR__."/configure_log_file.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	if( !isset($options['i']) ) {
		GWTLogHelper::error( "Specify wikiid (-i)" );
		die(1);
	}

	$wikiRepository = new GWTWikiRepository();

	$wikiRepository->deleteAllByWikiId( $options['i'] );

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
