<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
require_once( $GLOBALS["IP"]."/extensions/wikia/WikiaStats/WikiaStatsAutoHubsConsumer.php" );

$Maintenance = new WikiaStatsAutoHubsConsumer();
$Maintenance->receiveFromStomp();
