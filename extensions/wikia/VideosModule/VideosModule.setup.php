<?php

/**
 * VideosModule
 *
 * @author James Sutterfield
 * @author Saipetch Kongkatong
 * @author Liz Lee
 * @author Garth Webb
 * @author Kenneth Kouot
 *
 * @date 2014-01-21
 */

$wgExtensionCredits['videosmodule'][] = array(
	'name' => 'VideosModule',
	'author' => array(
		"James Sutterfield <james at wikia-inc.com>",
		"Saipetch Kongkatong <saipetch at wikia-inc.com>",
		"Liz Lee <liz at wikia-inc.com>",
		"Garth Webb <garth at wikia-inc.com>",
		"Kenneth Kouot <kenneth at wikia-inc.com>",
	),
	'descriptionmsg' => 'wikia-videosmodule-desc',
);

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses[ 'VideosModule'] =  $dir. 'VideosModule.class.php' ;

/**
 * controllers
 */
$wgAutoloadClasses['VideosModuleController'] =  $dir . 'VideosModuleController.class.php';

/**
 * hooks
 */
$wgAutoloadClasses['VideosModuleHooks'] =  $dir . 'VideosModuleHooks.class.php';
$wgHooks['OutputPageBeforeHTML'][] = 'VideosModuleHooks::onOutputPageBeforeHTML';

$wgHooks['GetRailModuleList'][] = 'VideosModuleHooks::onGetRailModuleList';

/**
 * messages
 */
$wgExtensionMessagesFiles['VideosModule'] = $dir . 'VideosModule.i18n.php';

// register messages package for JS
JSMessages::registerPackage( 'VideosModule', array(
	'videosmodule-title-default',
));
