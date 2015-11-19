<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'EmergencyBroadcastSystem',
	'version' => '1.0',
	'author' => 'Paul Oslund',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['EmergencyBroadcastSystemController'] =  $dir . '/EmergencyBroadcastSystemController.class.php';
$wgAutoloadClasses['EmergencyBroadcastSystemHooks'] =  $dir . '/EmergencyBroadcastSystemHooks.class.php';

$wgHooks['BeforePageDisplay'][] = 'EmergencyBroadcastSystemHooks::onBeforePageDisplay';
