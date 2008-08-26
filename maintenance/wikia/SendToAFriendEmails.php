<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
require_once( $GLOBALS["IP"]."/extensions/wikia/SendToAFriend/SendToAFriendMaintenance.php" );

$oMaintenance = new SendToAFriendMaintenance();
$oMaintenance->execute();
