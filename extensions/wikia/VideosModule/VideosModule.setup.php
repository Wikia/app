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
$wgAutoloadClasses['VideosModule\Base'] =  $dir . 'VideosModuleBase.class.php' ;
$wgAutoloadClasses['VideosModule\Category'] =  $dir . 'VideosModuleCategory.class.php' ;
$wgAutoloadClasses['VideosModule\Local'] =  $dir . 'VideosModuleLocal.class.php' ;
$wgAutoloadClasses['VideosModule\Related'] =  $dir . 'VideosModuleRelated.class.php' ;
$wgAutoloadClasses['VideosModule\Staff'] =  $dir . 'VideosModuleStaff.class.php' ;
$wgAutoloadClasses['VideosModule\Vertical'] =  $dir . 'VideosModuleVertical.class.php' ;

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
