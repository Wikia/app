<?php
/**
 * Created by JetBrains PhpStorm.
 * User: suchy
 * Date: 04.10.13
 * Time: 13:04
 * To change this template use File | Settings | File Templates.
 */

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['HubRssFeedSpecialController']	= $dir . 'HubRssFeedSpecialController.class.php';
$wgAutoloadClasses['HubRssFeedModel']	= $dir . 'HubRssFeedModel.class.php';

$wgSpecialPages['HubRssFeed']		= 'HubRssFeedSpecialController';

//hook for purging Achievemets-related cache
//$wgHooks['AchievementsInvalidateCache'][] = 'OnAchievementsInvalidateCache';
