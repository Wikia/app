<?php
/**
 * Rail Extension based on Oasis module
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = [
	'name' => 'Rail',
	'description' => 'Right Rail for pages',
	'authors' => [
		'Barosz "V." Bentkowski',
	],
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Rail'
];

// models
$wgAutoloadClasses['RailController'] =  __DIR__.'/RailController.class.php';
