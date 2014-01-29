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
$wgAutoloadClasses[ 'VideosModuleHelper'] =  $dir. '/VideosModuleHelper.class.php' ;

/**
 * controllers
 */
$wgAutoloadClasses['VideosModuleController'] =  $dir . '/VideosModuleController.class.php';

/**
 * hooks
 */
$wgAutoloadClasses['VideosModuleHooks'] =  $dir . '/VideosModuleHooks.class.php';

if ( $wgVideosModuleOnRail ) {
	$wgHooks['GetRailModuleList'][] = 'VideosModuleHooks::onGetRailModuleList';
} else {
	array_splice( $wgHooks['OutputPageBeforeHTML'], 0, 0, 'VideosModuleHooks::onOutputPageBeforeHTML' );
}

/**
 * messages
 */
$wgExtensionMessagesFiles['VideosModule'] = $dir . '/VideosModule.i18n.php';
