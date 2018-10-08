<?php

$GLOBALS['wgAutoloadClasses']['ResetTrackingPreferencesSpecialController'] = __DIR__ . '/ResetTrackingPreferencesSpecialController.class.php';
$wgSpecialPages['ResetTrackingPreferences'] = 'ResetTrackingPreferencesSpecialController';

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

$GLOBALS['wgResourceModules']['ext.wikia.resetTrackingSettings'] = [
	'scripts' => [ 'js/ext.wikia.resetTrackingSettings.js' ],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/TrackingOptIn',
];
