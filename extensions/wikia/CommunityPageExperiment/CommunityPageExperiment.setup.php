<?php

/**
 * Quick extension for the experiment with user landing pages.
 *
 * It's hacky, but it's going to be thrown away soon for a real
 * implementation.
 */

$wgAutoloadClasses['CommunityPageExperimentSpecialController'] =  __DIR__ . '/CommunityPageExperimentSpecialController.class.php';
$wgAutoloadClasses['CommunityTasksPageSpecialController'] =  __DIR__ . '/CommunityTasksPageSpecialController.class.php';
$wgAutoloadClasses['CommunityPageExperimentHelper'] =  __DIR__ . '/CommunityPageExperimentHelper.class.php';
$wgAutoloadClasses['CommunityPageExperimentHooks'] =  __DIR__ . '/CommunityPageExperimentHooks.class.php';

$wgExtensionMessagesFiles['CommunityPageExperiment'] = __DIR__ . '/CommunityPageExperiment.i18n.php' ;

$wgSpecialPages['Community'] = 'CommunityPageExperimentSpecialController';
$wgSpecialPages['CommunityTasks'] = 'CommunityTasksPageSpecialController';

$wgHooks['BeforePageDisplay'][] = 'CommunityPageExperimentHooks::onBeforePageDisplay';

$wgResourceModules['ext.communityPageExperiment'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CommunityPageExperiment/modules',
	'styles' => 'ext.communityPageExperiment.scss',
	'scripts' => 'ext.communityPageExperiment.js',
];

$wgResourceModules['ext.communityPageExperimentEntryPointInit'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CommunityPageExperiment/modules',
	'scripts' => 'ext.communityPageExperimentEntryPoint.js',
	'dependencies' => [
		'mediawiki.user',
	]
];

$wgResourceModules['ext.communityPageExperimentEntryPoint'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CommunityPageExperiment/modules',
	'styles' => 'ext.communityPageExperimentEntryPoint.scss',
	'messages' => [
		'communitypageexperiment-entry-join',
		'communitypageexperiment-entry-learn-more',
		'communitypageexperiment-entry-button',
		'communitypageexperiment-entry-tasks',
	]
];
