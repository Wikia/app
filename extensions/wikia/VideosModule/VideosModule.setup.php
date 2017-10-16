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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/VideosModule'
);

$dir = dirname( __FILE__ ) . '/';

/**
 * classes
 */
$wgAutoloadClasses['VideosModule\Modules\Base'] =  $dir . 'Modules/VideosModuleBase.class.php';
$wgAutoloadClasses['VideosModule\Modules\Category'] =  $dir . 'Modules/VideosModuleCategory.class.php';
$wgAutoloadClasses['VideosModule\Modules\Related'] =  $dir . 'Modules/VideosModuleRelated.class.php';
$wgAutoloadClasses['VideosModule\Modules\Staff'] =  $dir . 'Modules/VideosModuleStaff.class.php';

/**
 * controllers
 */
$wgAutoloadClasses['VideosModuleController'] =  $dir . 'VideosModuleController.class.php';

/**
 * hooks
 */
$wgAutoloadClasses['VideosModuleHooks'] =  $dir . 'VideosModuleHooks.class.php';
$wgHooks['OutputPageBeforeHTML'][] = 'VideosModuleHooks::onOutputPageBeforeHTML';

/**
 * messages
 */
$wgExtensionMessagesFiles['VideosModule'] = $dir . 'VideosModule.i18n.php';

// register messages package for JS
JSMessages::registerPackage( 'VideosModule', array(
	'videosmodule-title-default',
));
