<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Recommendations',
	'author' => 'Łukasz Konieczny',
	'description' => 'Recommendations',
	'version' => 1.0
);

$wgAutoloadClasses['RecommendationsHooks'] =  __DIR__ . '/RecommendationsHooks.class.php';

$wgHooks['OutputPageBeforeHTML'][] = 'RecommendationsHooks::onOutputPageBeforeHTML';

$wgExtensionMessagesFiles['Recommendations'] = __DIR__ . '/Recommendations.i18n.php';

$wgResourceModules['ext.wikia.recommendations'] = [
	'scripts' => [
		'extensions/wikia/Recommendations/scripts/recommendations.module.js',
		'extensions/wikia/Recommendations/scripts/init.js',
		'resources/wikia/modules/nodeFinder.js',
	]
];

JSMessages::registerPackage( 'Recommendations', [
	'recommendations-header',
] );
