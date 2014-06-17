<?php

/**
 * Affiliate Module
 *
 * @author James Ogura
 * @author John Limmordino
 * @author Saipetch Kongkatong
 * @author Ted Gill
 */

$wgExtensionCredits['affiliatemodule'][] = [
	'name' => 'AffiliateModule',
	'author' => [
		'James Ogura',
		'John Limmordino',
		'Saipetch Kongkatong',
		'Ted Gill',
	],
	'description' => 'Affiliate Module',
];

$dir = dirname( __FILE__ ) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['AffiliateModuleController'] =  $dir . 'AffiliateModuleController.class.php';

/**
 * hooks
 */
$wgAutoloadClasses['AffiliateModuleHooks'] =  $dir . 'AffiliateModuleHooks.class.php';
$wgHooks['GetRailModuleList'][] = 'AffiliateModuleHooks::onGetRailModuleList';

/**
 * messages
 */
$wgExtensionMessagesFiles['AffiliateModule'] = $dir . 'AffiliateModule.i18n.php';
