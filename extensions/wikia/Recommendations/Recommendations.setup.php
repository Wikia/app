<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Recommendations',
	'author' => 'Łukasz Konieczny',
	'descriptionmsg' => 'recommendations-desc',
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Recommendations'
);

$wgAutoloadClasses['RecommendationsHooks'] =  __DIR__ . '/RecommendationsHooks.class.php';

$wgHooks['OutputPageBeforeHTML'][] = 'RecommendationsHooks::onOutputPageBeforeHTML';

$wgExtensionMessagesFiles['Recommendations'] = __DIR__ . '/Recommendations.i18n.php';

$wgResourceModules['ext.wikia.recommendations'] = [
	'scripts' => [
		'extensions/wikia/Recommendations/scripts/recommendations.module.js',
		'extensions/wikia/Recommendations/scripts/init.js',
	]
];

JSMessages::registerPackage( 'Recommendations', [
	'recommendations-header',
] );
