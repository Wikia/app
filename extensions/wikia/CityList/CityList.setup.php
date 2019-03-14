<?php
/**
 * Handle updating shared city_list table
 */

$GLOBALS['wgAutoloadClasses']['UpdateCityListTask'] = __DIR__ . '/UpdateCityListTask.php';

function wfScheduleCityListUpdateTask() {
	$timestamp = wfTimestampNow();

	$task = UpdateCityListTask::newLocalTask();

	$task->call( 'updateLastTimestamp', $timestamp );
	$task->setQueue( \Wikia\Tasks\Queues\DeferredInsertsQueue::NAME );
	$task->queue();
}

$GLOBALS['wgHooks']['ArticleSaveComplete'][] = 'wfScheduleCityListUpdateTask';
$GLOBALS['wgHooks']['ArticleDeleteComplete'][] = 'wfScheduleCityListUpdateTask';
$GLOBALS['wgHooks']['ArticleUndelete'][] = 'wfScheduleCityListUpdateTask';
$GLOBALS['wgHooks']['TitleMoveComplete'][] = 'wfScheduleCityListUpdateTask';
