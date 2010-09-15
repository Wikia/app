<?php
/**
 * This script creates WidgetBox Hot Content cache for all accepted hubs.
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Jakub Kurcek <jakub@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php WidgetBoxHotContentImageGenerator.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );

require_once( 'commandLine.inc' );

echo( "Starting cache... \n\n" );

require_once( $GLOBALS["IP"]."/extensions/wikia/SpecialWidgetBoxRSS/WidgetBoxRSS.body.php" );
require_once( $GLOBALS["IP"]."/extensions/wikia/SpecialWidgetBoxRSS/WidgetBoxRSS.class.php" );
require_once( $GLOBALS["IP"]."/extensions/wikia/AutoHubsPages/AutoHubsPagesHelper.class.php" );
require_once( $GLOBALS["IP"]."/extensions/wikia/WikiaStats/WikiaStatsAutoHubsConsumerDB.php" );

$WidgetBoxFeedGenerator = new WidgetBoxRSS;

foreach ( $WidgetBoxFeedGenerator->allowedHubs() as $key => $val ){

	try {
		$WidgetBoxFeedGenerator->ReloadHotContentFeed( $val );
		echo " {$val} | {$key} - ok \n";
	} catch ( Exception $e ) {
		echo " {$val} | {$key} - Caught exception: $e->getMessage() \n";
	}
}
echo( "\n Job done" );

?>
