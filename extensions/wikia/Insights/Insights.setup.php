<?php

/**
 * Insights
 *
 * @author Łukasz Konieczny
 * @author Adam Karminski
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Insights',
	'descriptionmsg' => 'insights-desc',
	'authors' => [
		'Łukasz Konieczny',
		'Adam Karminski <adamk@wikia-inc.com>'
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Insights'
];

//classes
$wgAutoloadClasses['InsightsController'] = $dir . 'InsightsController.class.php';
$wgAutoloadClasses['InsightsHelper'] = $dir . 'InsightsHelper.php';

//models
$wgAutoloadClasses['InsightsModel'] = $dir . 'models/InsightsModel.php';
$wgAutoloadClasses['InsightsQuerypageModel'] = $dir . 'models/InsightsQuerypageModel.php';
$wgAutoloadClasses['InsightsUncategorizedModel'] = $dir . 'models/InsightsUncategorizedModel.php';
$wgAutoloadClasses['InsightsWithoutimagesModel'] = $dir . 'models/InsightsWithoutimagesModel.php';
$wgAutoloadClasses['InsightsDeadendModel'] = $dir . 'models/InsightsDeadendModel.php';
$wgAutoloadClasses['InsightsWantedpagesModel'] = $dir . 'models/InsightsWantedpagesModel.php';

// right rail module
$wgAutoloadClasses['InsightsModuleController'] = $IP.'/skins/oasis/modules/InsightsModuleController.class.php';

// hooks
$wgAutoloadClasses['InsightsHooks'] = $dir . 'InsightsHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'InsightsHooks::onBeforePageDisplay';
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'InsightsHooks::AfterActionBeforeRedirect';
$wgHooks['ArticleCreateBeforeRedirect'][] = 'InsightsHooks::AfterActionBeforeRedirect';
$wgHooks['GetLocalURL'][] = 'InsightsHooks::onGetLocalURL';
$wgHooks['GetRailModuleList'][] = 'InsightsHooks::onGetRailModuleList';

//special page
$wgSpecialPages['Insights'] = 'InsightsController';

//message files
$wgExtensionMessagesFiles['Insights'] = $dir . 'Insights.i18n.php';
