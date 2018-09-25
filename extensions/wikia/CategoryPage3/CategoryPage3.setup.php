<?php
$wgExtensionCredits['other'][] = [
	'name' => 'CategoryPage3 Extension',
	'author' => [
		'Igor Rogatty',
	],
	'description' => 'SEO friendly category pages',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CategoryPage3Hooks'
];

$wgAutoloadClasses['CategoryPage3Hooks'] = __DIR__ . '/CategoryPage3Hooks.class.php';

$wgHooks['ArticleFromTitle'][] = 'CategoryPage3Hooks::onArticleFromTitle';
