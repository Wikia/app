<?php
/**
 * This script creates Partner Feed Hot Content cache for all accepted hubs.
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Jakub Kurcek <jakub@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php PartnerFeedContentImageGenerator.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );

require_once( 'commandLine.inc' );

echo( "Starting cache... \n\n" );

$PartnerFeedGenerator = new PartnerFeed;

foreach ( $PartnerFeedGenerator->allowedHubs() as $key => $val ){

	try {
		if ( !is_array($val) ){
			$oTitle = Title::newFromText( $key, 150 );
			$hubId = AutoHubsPagesHelper::getHubIdFromTitle( $oTitle );
			$PartnerFeedGenerator->ReloadHotContentFeed( $hubId );
			echo " {$key} | {$hubId} | {$oTitle->getText()} - ok \n";
		}
		
	} catch ( Exception $e ) {
		echo " {$val} | {$key} - Caught exception: $e->getMessage() \n";
	}
}
echo( "\n My job is done here \n" );

?>
