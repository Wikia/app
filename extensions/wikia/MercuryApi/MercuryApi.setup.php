<?php
/**
 * Mercury API Extension
 *
 * @author Evgeniy 'aquilax' Vasilev
 */
$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['api'][] = [
	'name' => 'Mercury API',
	'descriptionmsg' => 'mercuryapi-desc',
	'authors' => [
		'Evgeniy "aquilax" Vasilev',
	],
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/MercuryApi'
];

// i18n
$wgExtensionMessagesFiles['MercuryApi'] = $dir . 'MercuryApi.i18n.php';

// Load needed classes
$wgAutoloadClasses['MercuryApiController'] = $dir . 'MercuryApiController.class.php';
$wgAutoloadClasses['MercuryApiHooks'] = $dir . 'MercuryApiHooks.class.php';

// model classes
$wgAutoloadClasses['MercuryApi'] = $dir . 'models/MercuryApi.class.php';
$wgAutoloadClasses['MercuryApiArticleHandler'] = $dir . 'handlers/MercuryApiArticleHandler.class.php';
$wgAutoloadClasses['MercuryApiCategoryHandler'] = $dir . 'handlers/MercuryApiCategoryHandler.class.php';
$wgAutoloadClasses['MercuryApiMainPageHandler'] = $dir . 'handlers/MercuryApiMainPageHandler.class.php';

// Add new API controller to API controllers list
$wgWikiaApiControllers['MercuryApiController'] = $dir . 'MercuryApiController.class.php';

// Hooks
$wgHooks['ArticleSaveComplete'][] = 'MercuryApiHooks::onArticleSaveComplete';
$wgHooks['ArticleRollbackComplete'][] = 'MercuryApiHooks::onArticleRollbackComplete';
$wgHooks['TitleGetSquidURLs'][] = 'MercuryApiHooks::onTitleGetSquidURLs';
$wgHooks['InstantGlobalsGetVariables'][] = 'MercuryApiHooks::onInstantGlobalsGetVariables';
$wgHooks['CuratedContentSave'][] = 'MercuryApiHooks::onCuratedContentSave';
