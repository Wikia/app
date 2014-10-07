<?php

/**
 * Monetization Module
 *
 * @author James Ogura
 * @author John Immordino
 * @author Saipetch Kongkatong
 * @author Ted Gill
 */

$wgExtensionCredits['monetizationmodule'][] = [
	'name' => 'MonetizationModule',
	'author' => [
		'James Ogura',
		'John Immordino',
		'Saipetch Kongkatong',
		'Ted Gill',
	],
	'description' => 'Monetization Module',
];

$dir = dirname( __FILE__ ) . '/';

// autoload
$wgAutoloadClasses['MonetizationModuleController'] =  $dir . 'MonetizationModuleController.class.php';
$wgAutoloadClasses['MonetizationModuleHelper'] = $dir . 'MonetizationModuleHelper.class.php';
$wgAutoloadClasses['MonetizationModuleHooks'] = $dir . 'MonetizationModuleHooks.class.php';

// i18n mapping
$wgExtensionMessagesFiles['MonetizationModule'] = $dir . 'MonetizationModule.i18n.php';

// hooks
$wgHooks['OasisSkinAssetGroupsBlocking'][] = 'MonetizationModuleHooks::onOasisSkinAssetGroupsBlocking';

