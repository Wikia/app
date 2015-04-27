<?php

/**
 * Insights
 *
 * This extension provides a set of subpages with insights on articles that
 * require more attention than others. It's one of productivity boosting features
 * for Power Users that focuses their efforts in the places that really need them.
 *
 * @author Łukasz Konieczny
 * @author Adam Karminski
 * @author Kamil Koterba
 */

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Insights',
	'descriptionmsg' => 'insights-desc',
	'authors' => [
		'Łukasz Konieczny',
		'Adam Karminski <adamk@wikia-inc.com>',
		'Kamil Koterba',
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Insights',
];

/**
 * The main classes
 */
$wgAutoloadClasses['InsightsController'] = $dir . 'InsightsController.class.php';
$wgAutoloadClasses['InsightsHelper'] = $dir . 'InsightsHelper.php';

/**
 * Special pages
 */
$wgSpecialPages['Insights'] = 'InsightsController';

/**
 * Models
 */
$wgAutoloadClasses['InsightsModel'] = $dir . 'models/InsightsModel.php';
$wgAutoloadClasses['InsightsQuerypageModel'] = $dir . 'models/InsightsQuerypageModel.php';
$wgAutoloadClasses['InsightsUncategorizedModel'] = $dir . 'models/InsightsUncategorizedModel.php';
$wgAutoloadClasses['InsightsWithoutimagesModel'] = $dir . 'models/InsightsWithoutimagesModel.php';
$wgAutoloadClasses['InsightsDeadendModel'] = $dir . 'models/InsightsDeadendModel.php';
$wgAutoloadClasses['InsightsWantedpagesModel'] = $dir . 'models/InsightsWantedpagesModel.php';

/**
 * The right rail module
 */
$wgAutoloadClasses['InsightsModuleController'] = $IP.'/skins/oasis/modules/InsightsModuleController.class.php';

/**
 * Hooks
 */
$wgAutoloadClasses['InsightsHooks'] = $dir . 'InsightsHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'InsightsHooks::onBeforePageDisplay';
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'InsightsHooks::AfterActionBeforeRedirect';
$wgHooks['ArticleCreateBeforeRedirect'][] = 'InsightsHooks::AfterActionBeforeRedirect';
$wgHooks['GetLocalURL'][] = 'InsightsHooks::onGetLocalURL';
$wgHooks['MakeGlobalVariablesScript'][] = 'InsightsHooks::onMakeGlobalVariablesScript';
$wgHooks['GetRailModuleList'][] = 'InsightsHooks::onGetRailModuleList';

/**
 * Message files
 */
$wgExtensionMessagesFiles['Insights'] = $dir . 'Insights.i18n.php';
