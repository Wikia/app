<?php
/**
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Władysław Bodzek <wladek@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php RenameIP_local.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( "include_path", dirname(__FILE__)."/../" );

$options = array('help');

$optionsWithArgs = array(
	'old-ip',
	'new-ip',
	'old-ip-enc',
	'new-ip-enc',
	'phalanx-block-id',
	'task-id',
	'requestor-id',
	'reason',
	'global-task-id'
);

require_once( 'commandLine.inc' );
global $IP, $wgCityId;

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: SERVER_ID=target_cityId php RenameIP_local.php --rename-old-ip {string} --rename-new-ip {string} --requestor-id {int} [--phalanx-block-id {int}] [--task-id {int}] [--reason {string}] --conf {path} --aconf {path}\n\n" );
	exit( 0 );
}

// BAC-602: decode user names if they were encoded in the first place
if ( !empty( $options['old-ip-enc'] ) ) {
	$options['old-ip'] = rawurldecode($options['old-ip-enc']);
}
if ( !empty( $options['new-ip-enc'] ) ) {
	$options['new-ip'] = rawurldecode($options['new-ip-enc']);
}

if ( empty($options['old-ip']) || empty($options['new-ip']) ) {
	echo( "Not enough arguments or invalid values. Required are: --old-ip, --new-ip");
	exit( 0 );
}

echo("Process for wiki with ID {$wgCityId} started.");

$taskId = (!empty($options['taskid'])) ? (int)$options['taskid'] : null;

$processData = array(
	'old_ip' => (string)$options['old-ip'],
	'new_ip' => (string)$options['new-ip'],
);

if (!empty($options['requestor-id']) && is_numeric($options['requestor-id']))
	$processData['requestor_id'] = (int)$options['requestor-id'];

if (!empty($options['phalanx-block-id']) && is_numeric($options['phalanx-block-id']))
	$processData['phalanx_block_id'] = (int)$options['phalanx-block-id'];

if (!empty($options['reason']))
	$processData['reason'] = $options['reason'];

if (!empty($options['global-task-id']) && is_numeric($options['global-task-id']))
	$processData['global_task_id'] = (int)$options['global-task-id'];

require_once("$IP/extensions/wikia/CoppaTool/CoppaTool.setup.php");

$process = RenameIPProcess::newFromData($processData);
$process->setLogDestination(RenameIPProcess::LOG_OUTPUT);

if($taskId) {
	$runningTask = RenameIPLocalTask::newFromID($taskId);

	if(defined('ENV_DEVBOX')){
		$process->addLogDestination(RenameIPProcess::LOG_BATCH_TASK, $runningTask);
	}
	else{
		$process->setLogDestination(RenameIPProcess::LOG_BATCH_TASK, $runningTask);
	}
}
$process->setRequestorUser();

try {
	$process->updateLocalIP();
	$errors = $process->getErrors();
} catch (Exception $e) {
	$errors = $process->getErrors();
	$errors[] = "Exception in updateLocalIP(): ".$e->getMessage() . ' in ' . $e->getFile() . ' at line ' . $e->getLine();

	\Wikia\Logger\WikiaLogger::instance()->error( 'updateLocalIP', [
		'exception' => $e
	] );
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
