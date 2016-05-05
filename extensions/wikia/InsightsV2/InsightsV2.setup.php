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

$dir = __DIR__ . '/';

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Insights',
	'descriptionmsg' => 'insights-desc',
	'author' => [
		'Łukasz Konieczny',
		'Adam Karminski <adamk@wikia-inc.com>',
		'Kamil Koterba',
		],
	'version' => '2.0',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/InsightsV2',
];

/**
 * The main classes
 */
$wgAutoloadClasses['InsightsController'] = $dir . 'InsightsController.class.php';
$wgAutoloadClasses['InsightsLoopController'] = $dir . 'InsightsLoopController.class.php';
$wgAutoloadClasses['InsightsContext'] = $dir . 'InsightsContext.class.php';

/**
 * Config
 */
$wgAutoloadClasses['InsightsConfig'] = $dir . 'helpers/InsightsConfig.php';

/**
 * Helpers
 */
$wgAutoloadClasses['InsightsHelper'] = $dir . 'InsightsHelper.php';
$wgAutoloadClasses['InsightsPaginator'] = $dir . 'helpers/InsightsPaginator.php';
$wgAutoloadClasses['InsightsSorting'] = $dir . 'helpers/InsightsSorting.php';
$wgAutoloadClasses['InsightsCache'] = $dir . 'helpers/InsightsCache.php';
$wgAutoloadClasses['InsightsPageViews'] = $dir . 'helpers/InsightsPageViews.php';
$wgAutoloadClasses['InsightsItemData'] = $dir . 'helpers/InsightsItemData.php';

/**
 * Special pages
 */
$wgSpecialPages['Insights'] = 'InsightsController';
$wgSpecialPageGroups['Insights'] = 'wikia';

/**
 * Models
 */
$wgAutoloadClasses['InsightsModel'] = $dir . 'models/InsightsModel.php';
$wgAutoloadClasses['InsightsQueryPageModel'] = $dir . 'models/InsightsQueryPageModel.php';
$wgAutoloadClasses['InsightsDeadendModel'] = $dir . 'models/InsightsDeadendModel.php';
$wgAutoloadClasses['InsightsUncategorizedModel'] = $dir . 'models/InsightsUncategorizedModel.php';
$wgAutoloadClasses['InsightsUnconvertedInfoboxesModel'] = $dir . 'models/InsightsUnconvertedInfoboxesModel.php';
$wgAutoloadClasses['InsightsWantedpagesModel'] = $dir . 'models/InsightsWantedpagesModel.php';
$wgAutoloadClasses['InsightsWithoutimagesModel'] = $dir . 'models/InsightsWithoutimagesModel.php';

/**
 * Service
 */
$wgAutoloadClasses['InsightsCountService'] = $dir . 'services/InsightsCountService.class.php';
$wgAutoloadClasses['InsightsCountApiController'] = $dir . 'controllers/InsightsCountApiController.class.php';
$wgAutoloadClasses['InsightsService'] = $dir . 'services/InsightsService.class.php';

/**
 * The right rail module
 */
$wgAutoloadClasses['InsightsModuleController'] = $IP.'/skins/oasis/modules/InsightsModuleController.class.php';

/**
 * Hooks
 */
$wgAutoloadClasses['InsightsHooks'] = $dir . 'InsightsHooks.class.php';
$wgHooks['BeforePageDisplay'][] = 'InsightsHooks::onBeforePageDisplay';
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'InsightsHooks::onAfterActionBeforeRedirect';
$wgHooks['ArticleCreateBeforeRedirect'][] = 'InsightsHooks::onAfterActionBeforeRedirect';
$wgHooks['MakeGlobalVariablesScript'][] = 'InsightsHooks::onMakeGlobalVariablesScript';
$wgHooks['GetRailModuleList'][] = 'InsightsHooks::onGetRailModuleList';
$wgHooks['wgQueryPages'][] = 'InsightsHooks::onwgQueryPages';
$wgHooks['AfterUpdateSpecialPages'][] = 'InsightsHooks::onAfterUpdateSpecialPages';

$wgExtensionFunctions[] = 'InsightsHooks::init';


/**
 * Message files
 */
$wgExtensionMessagesFiles['Insights'] = $dir . 'Insights.i18n.php';
$wgExtensionMessagesFiles['InsightsAliases'] = $dir . 'Insights.alias.php';
