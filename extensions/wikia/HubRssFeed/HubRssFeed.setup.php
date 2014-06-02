<?php

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['HubRssFeedSpecialController']	= $dir . 'HubRssFeedSpecialController.class.php';
$wgAutoloadClasses['HubRssFeedModel']	= $dir . 'models/external/HubRssFeedModel.class.php';
$wgAutoloadClasses['HubRssFeedService']	= $dir . 'HubRssFeedService.class.php';
$wgAutoloadClasses['RssFeedService']	= $dir . 'RssFeedService.class.php';
$wgAutoloadClasses['BaseRssModel']	= $dir . 'models/BaseRssModel.class.php';
$wgAutoloadClasses['TvRssModel']	= $dir . 'models/TvRssModel.class.php';
$wgAutoloadClasses['GamesRssModel']	= $dir . 'models/GamesRssModel.class.php';
$wgAutoloadClasses['PopularArticlesModel']	= $dir . 'models/external/PopularArticlesModel.class.php';
$wgAutoloadClasses['EntertainmentHubOnlyRssModel'] = $dir . 'models/EntertainmentHubOnlyRssModel.class.php';
$wgAutoloadClasses['LifestyleHubOnlyRssModel'] = $dir . 'models/LifestyleHubOnlyRssModel.class.php';
$wgAutoloadClasses['HubOnlyRssModel'] = $dir . 'models/HubOnlyRssModel.class.php';

$wgSpecialPages['HubRssFeed']		= 'HubRssFeedSpecialController';

$wgHubRssFeeds = array(
	 'Entertainment', 'Lifestyle', 'Games', 'TV', 'Tv'
);

foreach ( $wgHubRssFeeds as $feed ) {
	if ( isset( $_SERVER['SCRIPT_URL'] ) && strcmp( $_SERVER['SCRIPT_URL'],  '/rss/'.$feed ) === 0 ) {
		/*
		 * This is used by WebRequest::interpolateTitle to overwrite title in $_GET
		 * (based on $_SERVER['REQUEST_URI']).
		 * If we are using mod_rewrite for Hubs (e.g.: /rss/Lifestyle) we need to
		 * disable this functionality in order to be able serve special page
		 * instead of regular page.
		 */
		$wgUsePathInfo = false;
		break;
	}
}
