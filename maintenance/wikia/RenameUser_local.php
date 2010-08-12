<?php
/**
 * This script takes a snapshot of the current user ranking if Achievements extension is enabled and stores it in the
 * ach_ranking_snapshots table stored in $wgExternalSharedDB
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Władysław Bodzek <wladek@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php RenameUser_local.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );

$options = array('help');

$optionsWithArgs = array(
	'rename-user-id',
	'rename-old-name',
	'rename-new-name',
	'rename-fake-user-id',
	'phalanx-block-id',
	'task-id',
	'requestor-id',
	'reason',
	'global-task-id'
);

require_once( 'commandLine.inc' );
global $IP, $wgCityId;

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: SERVER_ID=target_cityId php RenameUser_local.php --rename-user-id {int} --rename-old-name {string} --rename-new-name {string} --requestor-id {int} [--phalanx-block-id {int}] [--task-id {int}] [--reason {string}] --conf {path} --aconf {path}\n\n" );
	exit( 0 );
}

if ( empty($options['rename-user-id']) || empty($options['rename-old-name']) || empty($options['rename-new-name']) ) {
	echo( "Not enough arguments or invalid values. Required are: --rename-user-id, --rename-old-name, --rename-new-name");
	exit( 0 );
}

echo("Process for wiki with ID {$wgCityId} started.");

$taskId = (!empty($options['taskid'])) ? (int)$options['taskid'] : null;

$processData = array(
	'rename_user_id' => (int)$options['rename-user-id'],
	'rename_old_name' => (string)$options['rename-old-name'],
	'rename_new_name' => (string)$options['rename-new-name'],
);

if (!empty($options['rename-fake-user-id']) && is_numeric($options['rename-fake-user-id']))
	$processData['rename_fake_user_id'] = (int)$options['rename-fake-user-id'];

if (!empty($options['requestor-id']) && is_numeric($options['requestor-id']))
	$processData['requestor_id'] = (int)$options['requestor-id'];

if (!empty($options['phalanx-block-id']) && is_numeric($options['phalanx-block-id']))
	$processData['phalanx_block_id'] = (int)$options['phalanx-block-id'];

if (!empty($options['reason']))
	$processData['reason'] = $options['reason'];

if (!empty($options['global-task-id']) && is_numeric($options['global-task-id']))
	$processData['global_task_id'] = (int)$options['global-task-id'];

require_once("$IP/extensions/wikia/UserRenameTool/SpecialRenameuser.php");

$process = RenameUserProcess::newFromData($processData);
$process->setLogDestination(RenameUserProcess::LOG_OUTPUT);

if($taskId) {
	$runningTask = UserRenameLocalTask::newFromID($taskId);

	if(defined('ENV_DEVBOX')){
		$process->addLogDestination(RenameUserProcess::LOG_BATCH_TASK, $runningTask);
	}
	else{
		$process->setLogDestination(RenameUserProcess::LOG_BATCH_TASK, $runningTask);
	}
}
$process->setRequestorUser();

try {
	$process->updateLocal();
	$errors = $process->getErrors();
} catch (Exception $e) {
	$errors = $process->getErrors();
	$errors[] = "Exception in updateLocal(): ".$e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine();
}

if(!empty($errors)){
	echo("Process for wiki with ID {$wgCityId} resulted in the following errors:\n");
	
	foreach($errors as $error){
		echo(" - $error\n");
	}

	exit(1);
}

echo("Process for wiki with ID {$wgCityId} was completed successfully");
exit(0);