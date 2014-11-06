<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Recommendations',
	'author' => 'Łukasz Konieczny',
	'description' => 'Recommendations',
	'version' => 1.0
);

$wgAutoloadClasses['RecommendationsController'] =  __DIR__ . '/RecommendationsController.class.php';

$wgExtensionMessagesFiles['Recommendations'] = __DIR__ . '/Recommendations.i18n.php';
