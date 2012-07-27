<?php

/**
 * RecentChanges
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'RecentChanges',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' )
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$app->registerClass('RecentChangesController', $dir . 'RecentChangesController.class.php');
$app->registerClass('RecentChangesHooks', $dir . 'RecentChangesHooks.class.php');
$app->registerClass('RecentChangesFiltersStorage', $dir . 'RecentChangesFiltersStorage.class.php');

// Hooks
$app->registerHook('onGetNamespaceCheckbox', 'RecentChangesHooks', 'onGetNamespaceCheckbox');
$app->registerHook('SpecialRecentChangesQuery', 'RecentChangesHooks', 'onGetRecentChangeQuery');
