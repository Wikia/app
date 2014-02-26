<?php

/**
 * @author James Sutterfield <james@wikia-inc.com>
 * @date 2014-01-21
 */

$wgExtensionCredits['videosmodule'][] = array(
	'name' => 'VideosModule',
	'author' => array(
		"James Sutterfield <james@wikia-inc.com>",
	),
	'descriptionmsg' => 'wikia-videosmodule-desc',
);

$dir = dirname( __FILE__ );

/**
 * classes
 */
$wgAutoloadClasses[ 'VideosModule'] =  $dir. '/VideosModule.class.php' ;

/**
 * controllers
 */
$wgAutoloadClasses['VideosModuleController'] =  $dir . '/VideosModuleController.class.php';

/**
 * hooks
 */
$wgAutoloadClasses['VideosModuleHooks'] =  $dir . '/VideosModuleHooks.class.php';
$wgHooks['OutputPageBeforeHTML'][] = 'VideosModuleHooks::onOutputPageBeforeHTML';

// Only load this hook handler if we're showing the VideosModule in the right rail
if ( F::app()->wg->VideosModuleABTest == 'rail' ) {
	$wgHooks['GetRailModuleList'][] = 'VideosModuleHooks::onGetRailModuleList';
}
$wgHooks['MakeGlobalVariablesScript'][] = 'VideosModuleHooks::onMakeGlobalVariablesScript';

/**
 * messages
 */
$wgExtensionMessagesFiles['VideosModule'] = $dir . '/VideosModule.i18n.php';

// register messages package for JS
JSMessages::registerPackage('VideosModule', array(
	'videosmodule-title-default',
));
