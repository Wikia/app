<?php

/**
 * RecentChanges
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'RecentChanges',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ),
	'descriptionmsg' => 'recentchanges-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/RecentChanges'
);

$dir = __DIR__ . '/';

//classes
$wgAutoloadClasses['RecentChangesController'] =  $dir . 'RecentChangesController.class.php';
$wgAutoloadClasses['RecentChangesHooks'] =  $dir . 'RecentChangesHooks.class.php';
$wgAutoloadClasses['RecentChangesFiltersStorage'] =  $dir . 'RecentChangesFiltersStorage.class.php';

// Hooks
$wgHooks['onGetNamespaceCheckbox'][] = 'RecentChangesHooks::onGetNamespaceCheckbox';
$wgHooks['SpecialRecentChangesQuery'][] = 'RecentChangesHooks::onGetRecentChangeQuery';
