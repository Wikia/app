<?php

/**
 * Affiliate Module
 *
 * @author James Ogura
 * @author John Immordino
 * @author Saipetch Kongkatong
 * @author Ted Gill
 */

$wgExtensionCredits['affiliatemodule'][] = [
	'name' => 'AffiliateModule',
	'author' => [
		'James Ogura',
		'John Immordino',
		'Saipetch Kongkatong',
		'Ted Gill',
	],
	'description' => 'Affiliate Module',
];

$dir = dirname( __FILE__ ) . '/';

// controllers
$wgAutoloadClasses['AffiliateModuleController'] =  $dir . 'AffiliateModuleController.class.php';

// classes
$wgAutoloadClasses['AffiliateModuleHelper'] = $dir . 'AffiliateModuleHelper.class.php';
$wgAutoloadClasses['AffiliateModuleHooks'] =  $dir . 'AffiliateModuleHooks.class.php';

// hooks
$wgHooks['GetRailModuleList'][] = 'AffiliateModuleHooks::onGetRailModuleList';

// i18n mapping
$wgExtensionMessagesFiles['AffiliateModule'] = $dir . 'AffiliateModule.i18n.php';
