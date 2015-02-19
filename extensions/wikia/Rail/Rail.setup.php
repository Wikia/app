<?php
/**
 * (Right) Rail
 */
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['other'][] = [
	'name' => 'Rail',
	'description' => 'Right Rail for pages',
	'authors' => [
		'Barosz "V." Bentkowski',
	],
	'version' => 1
];

// models
$wgAutoloadClasses['RailController'] =  __DIR__.'/RailController.class.php';


// message files
//$wgExtensionMessagesFiles['Rail'] = $dir.'Rail.i18n.php';
//JSMessages::registerPackage( 'Rail', array( 'special-Rail-*' ) );

// hooks
//$wgHooks['RequestContextCreateSkin'][] = 'RailController::onGetSkin';
