<?php

$wgExtensionCredits['other'][] =
	array(
		'name' => 'Ad Engine',
		'author' => 'Wikia',
		'description' => 'Tracking opt in',
		'version' => '1.0',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/TrackingOptIn',
	);

// Autoload
$wgAutoloadClasses['TrackingOptIn'] =  __DIR__ . '/TrackingOptIn.class.php';

$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'TrackingOptIn::onOasisSkinAssetGroupsBlocking';
