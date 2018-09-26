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
$wgAutoloadClasses['CategoryPage3Hooks'] = __DIR__ . '/CategoryPage3Hooks.class.php';
$wgAutoloadClasses['CategoryPage3Model'] = __DIR__ . '/CategoryPage3Model.class.php';
$wgAutoloadClasses['CategoryPage3Pagination'] = __DIR__ . '/CategoryPage3Pagination.class.php';

$wgHooks['ArticleFromTitle'][] = 'CategoryPage3Hooks::onArticleFromTitle';

$wgResourceModules['ext.wikia.CategoryPage3.scripts'] = [
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/CategoryPage3',
	'scripts' => 'scripts/category-page3.js',
];
