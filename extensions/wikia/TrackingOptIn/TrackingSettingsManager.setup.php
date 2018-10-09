<?php

$GLOBALS['wgAutoloadClasses']['TrackingSettingsManagerHooks'] = __DIR__ . '/TrackingSettingsManagerHooks.php';
$GLOBALS['wgHooks']['OutputPageParserOutput'][] = '\TrackingSettingsManagerHooks::onOutputPageAfterParserOutput';

$GLOBALS['wgResourceModules']['ext.wikia.trackingSettingsManager'] = [
	'scripts' => [ 'js/ext.wikia.trackingSettingsManager.js' ],
	'styles' => [ 'styles/ext.wikia.trackingSettingsManager.css' ],
	'messages' => [
		'privacy-settings-button-toggle',
		'privacy-settings-button-toggle-fandom'
	],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/TrackingOptIn',
];
