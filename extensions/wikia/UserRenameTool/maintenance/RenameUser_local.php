<?php
/**
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Władysław Bodzek <wladek@wikia-inc.com>
 *
 * @usage: SERVER_ID=177 php RenameUser_local.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 */

ini_set( "include_path", dirname( __FILE__ ) . "/../../../../maintenance" );

$options = [ 'help' ];

// Used by commandLine.inc
$optionsWithArgs = [
	'rename-user-id',
	'rename-old-name',
	'rename-new-name',
	'rename-old-name-enc',
	'rename-new-name-enc',
	'rename-fake-user-id',
	'phalanx-block-id',
	'task-id',
	'requestor-id',
	'reason',
	'global-task-id'
];

global $IP, $wgCityId;

require_once( 'commandLine.inc' );
require_once( "$IP/extensions/wikia/UserRenameTool/UserRenameTool.php" );


if ( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: SERVER_ID=target_cityId php RenameUser_local.php --rename-user-id {int} --rename-old-name {string} --rename-new-name {string} --requestor-id {int} [--phalanx-block-id {int}] [--task-id {int}] [--reason {string}] --conf {path} --aconf {path}\n\n" );
	exit( 0 );
}

// Send logging to STDOUT
$logger = Wikia\Logger\WikiaLogger::instance();
$logger->setLogger( $logger->stdoutLogger() );

validateOptions( $options );
$processData = getProcessData( $options );

/** @var \UserRenameTool\Process\ProcessLocal $process */
$process = \UserRenameTool\Process\ProcessLocal::newFromData( $processData );
$process->logInfo( "Starting local rename script" );

$process->setRequestorUser();

try {
	if ( isset( $options['rename-ip-address'] ) ) {
		$process->updateLocalIP();
	} else {
		$process->updateLocal();
	}

	$errors = $process->getErrors();
} catch ( Exception $e ) {
	$errors = $process->getErrors();
	$errors[] = sprintf(
		"Exception in updateLocal(): %s in %s at line %d",
		$e->getMessage(), $e->getFile(), $e->getLine()
	);
}

if ( !empty( $errors ) ) {
	$process->logError( "Local rename had errors:", [ "errors" => $errors ] );

	exit( 1 );
}

$process->logInfo( "Local rename completed successfully" );
exit( 0 );

function validateOptions( &$options ) {
	// BAC-602: decode user names if they were encoded in the first place
	if ( !empty( $options['rename-old-name-enc'] ) ) {
		$options['rename-old-name'] = rawurldecode( $options['rename-old-name-enc'] );
	}
	if ( !empty( $options['rename-new-name-enc'] ) ) {
		$options['rename-new-name'] = rawurldecode( $options['rename-new-name-enc'] );
	}

	if ( !is_numeric( $options['rename-user-id'] ) ||
		empty( $options['rename-old-name'] ) ||
		empty( $options['rename-new-name'] ) ) {

		echo( "Not enough arguments or invalid values. Required are: --rename-user-id, --rename-old-name, --rename-new-name" );
		exit( 0 );
	}
}

function getProcessData( $options ) {
	$processData = [
		'rename_user_id' => ( int ) $options['rename-user-id'],
		'rename_old_name' => ( string ) $options['rename-old-name'],
		'rename_new_name' => ( string ) $options['rename-new-name'],
	];

	if ( isset( $options['rename-ip-address'] ) ) {
		$processData['rename_ip'] = true;
	}

	if ( !empty( $options['rename-fake-user-id'] ) && is_numeric( $options['rename-fake-user-id'] ) ) {
		$processData['rename_fake_user_id'] = ( int ) $options['rename-fake-user-id'];
	}

	if ( !empty( $options['requestor-id'] ) && is_numeric( $options['requestor-id'] ) ) {
		$processData['requestor_id'] = ( int ) $options['requestor-id'];
	}

	if ( !empty( $options['phalanx-block-id'] ) && is_numeric( $options['phalanx-block-id'] ) ) {
		$processData['phalanx_block_id'] = ( int ) $options['phalanx-block-id'];
	}

	if ( !empty( $options['reason'] ) ) {
		$processData['reason'] = $options['reason'];
	}

	if ( !empty( $options['global-task-id'] ) && is_numeric( $options['global-task-id'] ) ) {
		$processData['global_task_id'] = ( int ) $options['global-task-id'];
	}

	return $processData;
}