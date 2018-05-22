<?php

$GLOBALS['wgAutoloadClasses']['TrackingSettingsManagerHooks'] = __DIR__ . '/TrackingSettingsManagerHooks.php';
$GLOBALS['wgHooks']['OutputPageParserOutput'][] = '\TrackingSettingsManagerHooks::onOutputPageAfterParserOutput';

$GLOBALS['wgResourceModules']['ext.wikia.trackingSettingsManager'] = [
	'scripts' => [ 'ext.wikia.trackingSettingsManager.js' ],
	'styles' => [ 'ext.wikia.trackingSettingsManager.css' ],
	'messages' => [ 'privacy-settings-button-toggle' ],

	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/Privacy',
];
