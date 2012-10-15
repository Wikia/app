<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
require_once( $GLOBALS["IP"]."/extensions/wikia/MultiTasks/SpecialMultiDelete.php" );

global $wgMaxShellTime, $wgMaxShellFileSize;
$wgMaxShellTime = 0;
$wgMaxShellFileSize = 0;

$add = ( isset($options['add']) ) ;
$TASK_ID = ( isset($options['TASK_ID']) ) ? $options['TASK_ID'] : 0;
if ( $add ) {
	$params = array(
		'page' => 'Ad_free_wikis_old',
		'newpage' => 'Ad_New_free_wikis_old',
		'user' => 'Moli.wikia',
		'redirect' => 1,
		'watch' => 1,
		'reason' => 'test moved 2',
		'selwikia' => 177
	);
	$thisTask = new MultiMoveTask( $params );
	$submit_id = $thisTask->submitForm();	
} elseif ( $TASK_ID ) {
	global $wgExternalSharedDB;
	$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
	$aCondition = array("task_id" => $TASK_ID);
	$oTask = $dbr->selectRow( "wikia_tasks", "*", $aCondition, __METHOD__, array( "ORDER BY" => "task_id") );

	$Maintenance = new MultiMoveTask();
	$Maintenance->execute($oTask);
} else {
	// do nothing 
	echo "nothing to do \n";
}

