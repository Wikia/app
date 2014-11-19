<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Recommendations',
	'author' => 'Łukasz Konieczny',
	'description' => 'Recommendations',
	'version' => 1.0
);

$wgAutoloadClasses['RecommendationsController'] =  __DIR__ . '/RecommendationsController.class.php';

$wgExtensionMessagesFiles['Recommendations'] = __DIR__ . '/Recommendations.i18n.php';

$wgResourceModules['ext.wikia.recommendations'] = [
	'scripts' => [
		'extensions/wikia/Recommendations/scripts/recommendations.js',
		'extensions/wikia/Recommendations/scripts/recommendations.tracking.js',
	]
];

JSMessages::registerPackage( 'Recommendations', [
	'recommendations-header',
] );
