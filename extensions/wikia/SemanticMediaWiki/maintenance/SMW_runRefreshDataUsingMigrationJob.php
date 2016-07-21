<?php



require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../../../maintenance/commandLine.inc' );

global $wgCityId;

$task = new SMW_MigrationJob();
(new \Wikia\Tasks\AsyncTaskList())
	->wikiId($wgCityId)
	->add($task->call('run', $wgCityId))
	->queue();
