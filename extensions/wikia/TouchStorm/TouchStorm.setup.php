<?php

/**
 * TouchStorm module
 *
 * TouchStorm is a 3rd party video recommendation module that uses our video library
 *
 * @author Garth Webb, Ken Kouot, Liz Lee, Saipetch Kongkatong
 *
 */

$wgExtensionCredits['touchstorm'][] = array(
	'name' => 'TouchStorm',
	'author' => array(
		"Garth Webb",
		"Ken Kouot",
		"Liz Lee",
		"Saipetch Kongkatong",
	),
	'descriptionmsg' => 'touchstorm-desc',
);

$dir = dirname( __FILE__ ) . '/';

// classes
$wgAutoloadClasses[ 'TouchStormHooks' ] = $dir . 'TouchStormHooks.class.php';

// Touch Storm controller
$wgAutoloadClasses[ 'TouchStormController' ] = $dir . 'TouchStormController.class.php';

// i18n mapping
$wgExtensionMessagesFiles['TouchStorm'] = $dir . 'TouchStorm.i18n.php' ;

// hooks
$wgHooks['GetRailModuleList'][] = 'TouchStormHooks::onGetRailModuleList';
