<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Recommendations',
	'author' => 'Łukasz Konieczny',
	'description' => 'Recommendations',
	'version' => 1.0
);

$wgAutoloadClasses['RecommendationsController'] =  __DIR__ . '/RecommendationsController.class.php';

$wgExtensionMessagesFiles['Recommendations'] = __DIR__ . '/Recommendations.i18n.php';

$wgResourceModules['ext.wikia.recommendations'] = array(
	'scripts' => array(
		'extensions/wikia/Recommendations/scripts/recommendations.js',
	),
	'styles' => array(
		'extensions/wikia/Recommendations/styles/recommendations.scss'
	)
);
