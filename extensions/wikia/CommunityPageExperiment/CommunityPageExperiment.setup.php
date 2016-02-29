<?php

/**
 * Quick extension for the experiment with user landing pages.
 *
 * It's hacky, but it's going to be thrown away soon for a real
 * implementation.
 */

$wgAutoloadClasses['CommunityPageExperimentSpecialController'] =  __DIR__ . '/CommunityPageExperimentSpecialController.class.php';
$wgAutoloadClasses['CommunityPageExperimentHooks'] =  __DIR__ . '/CommunityPageExperimentHooks.class.php';

$wgExtensionMessagesFiles['CommunityPageExperiment'] = __DIR__ . '/CommunityPageExperiment.i18n.php' ;

$wgSpecialPages['Community'] = 'CommunityPageExperimentSpecialController';

$wgHooks['PageHeaderIndexExtraButtons'][] = 'CommunityPageExperimentHooks::onPageHeaderIndexExtraButtons';

$wgResourceModules['ext.communityPageExperiment'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CommunityPageExperiment/modules',
	'styles' => 'ext.communityPageExperiment.scss',
	'scripts' => 'ext.communityPageExperiment.js',
];

$wgResourceModules['ext.communityPageExperimentEntryPoint'] = [
	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/CommunityPageExperiment/modules',
	'styles' => 'ext.communityPageExperimentEntryPoint.scss',
	'scripts' => 'ext.communityPageExperimentEntryPoint.js',
];
