<?php
/**
 * Handle updating shared city_list table
 */

$GLOBALS['wgAutoloadClasses']['UpdateCityListTask'] = __DIR__ . '/UpdateCityListTask.php';

function wfScheduleCityListUpdateTask() {
	global $wgCityId;

	$timestamp = wfTimestampNow();

	$task = ( new UpdateCityListTask() )->wikiId( $wgCityId );

	$task->call( 'updateLastTimestamp', $timestamp );

	$task->queue();
}

$GLOBALS['wgHooks']['ArticleSaveComplete'][] = 'wfScheduleCityListUpdateTask';
$GLOBALS['wgHooks']['ArticleDeleteComplete'][] = 'wfScheduleCityListUpdateTask';
$GLOBALS['wgHooks']['ArticleUndelete'][] = 'wfScheduleCityListUpdateTask';
$GLOBALS['wgHooks']['TitleMoveComplete'][] = 'wfScheduleCityListUpdateTask';
