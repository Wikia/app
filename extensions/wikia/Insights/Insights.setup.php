<?php

/**
 * Insights
 *
 * @author Łukasz Konieczny *
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
$wgAutoloadClasses['QueryPagesModel'] = $dir . 'models/QueryPagesModel.php';

// hooks
$wgAutoloadClasses['InsightsHooks'] = $dir . 'InsightsHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'InsightsHooks::onBeforePageDisplay';
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'InsightsHooks::onArticleUpdateBeforeRedirect';
$wgHooks['GetLocalURL'][] = 'InsightsHooks::onGetLocalURL';

//special page
$wgSpecialPages['Insights'] = 'InsightsController';
$wgSpecialPageGroups['EditHub'] = 'wikia';

//message files
$wgExtensionMessagesFiles['Insights'] = $dir . 'Insights.i18n.php';

