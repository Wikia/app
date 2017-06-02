<?php
/**
 * Rail Extension based on Oasis module
 */

$wgExtensionCredits['other'][] = [
	'name' => 'Rail',
	'description' => 'Right Rail for pages',
	'authors' => [
		'Bartosz "V." Bentkowski',
	],
	'version' => '1',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Rail'
];

// models
$wgAutoloadClasses['RailController'] =  __DIR__.'/RailController.class.php';

$wgResourceModules['ext.wikia.rail'] = [
	'scripts' => 'scripts/Rail.js',
	'dependencies' => [ 'ext.wikia.timeAgoMessaging' ],
	'source' => 'common',

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/Rail',
];
