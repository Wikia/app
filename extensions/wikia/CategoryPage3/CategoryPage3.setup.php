<?php
$wgExtensionCredits['other'][] = [
	'name' => 'CategoryPage3 Extension',
	'author' => [
		'Igor Rogatty',
	],
	'description' => 'SEO friendly category pages',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CategoryPage3Hooks'
];

$wgAutoloadClasses['CategoryPage3'] = __DIR__ . '/CategoryPage3.class.php';
$wgAutoloadClasses['CategoryPage3CacheHelper'] = __DIR__ . '/CategoryPage3CacheHelper.class.php';
$wgAutoloadClasses['CategoryPage3Hooks'] = __DIR__ . '/CategoryPage3Hooks.class.php';
$wgAutoloadClasses['CategoryPage3Member'] = __DIR__ . '/CategoryPage3Member.class.php';
$wgAutoloadClasses['CategoryPage3Model'] = __DIR__ . '/CategoryPage3Model.class.php';
$wgAutoloadClasses['CategoryPage3TrendingPages'] = __DIR__ . '/CategoryPage3TrendingPages.class.php';
$wgAutoloadClasses['CategoryPage3Pagination'] = __DIR__ . '/CategoryPage3Pagination.class.php';
$wgAutoloadClasses['CategoryPageMediawiki'] = __DIR__ . '/CategoryPageMediawiki.class.php';
$wgAutoloadClasses['CategoryPageWithLayoutSelector'] = __DIR__ . '/CategoryPageWithLayoutSelector.class.php';

$wgHooks['AfterCategoriesUpdate'][] = 'CategoryPage3Hooks::onAfterCategoriesUpdate';
$wgHooks['ArticleFromTitle'][] = 'CategoryPage3Hooks::onArticleFromTitle';
$wgHooks['BeforeInitialize'][] = 'CategoryPage3Hooks::onBeforeInitialize';
$wgHooks['GetPreferences'][] = 'CategoryPage3Hooks::onGetPreferences';
$wgHooks['LinkerMakeExternalLink'][] = 'CategoryPage3Hooks::onLinkerMakeExternalLink';
$wgHooks['MercuryArticleDetails'][] = 'CategoryPage3Hooks::onMercuryArticleDetails';
$wgHooks['UserGetDefaultOptions'][] = 'CategoryPage3Hooks::onUserGetDefaultOptions';
$wgHooks['WikiaCanonicalHref'][] = 'CategoryPage3Hooks::onWikiaCanonicalHref';

$wgExtensionMessagesFiles[ 'CategoryPage3' ] = __DIR__ . '/CategoryPage3.i18n.php';

$wgResourceModules['ext.wikia.CategoryPage3.categoryLayoutSelector.scripts'] = [
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/CategoryPage3',
	'scripts' => 'scripts/category-layout-selector.js',
];
