<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
require_once( $GLOBALS["IP"]."/extensions/wikia/TaskManager/TaskManagerExecutor.php" );

$allowedBatchTasks = array( 'renameuser_local', 'renameuser_global' );
foreach ($wgWikiaBatchTasks as $k => $v)
	if ( !in_array($k,$allowedBatchTasks) )
		unset($wgWikiaBatchTasks[$k]);

$Maintenance = new TaskManagerExecutor();
$Maintenance->execute();
