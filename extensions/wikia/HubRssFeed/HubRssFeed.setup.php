<?php

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['HubRssFeedSpecialController']	= $dir . 'HubRssFeedSpecialController.class.php';
$wgAutoloadClasses['HubRssFeedModel']	= $dir . 'models/external/HubRssFeedModel.class.php';
$wgAutoloadClasses['RssFeedService']	= $dir . 'RssFeedService.class.php';
$wgAutoloadClasses['BaseRssModel']	= $dir . 'models/BaseRssModel.class.php';
$wgAutoloadClasses['PopularArticlesModel']	= $dir . 'models/external/PopularArticlesModel.class.php';
$wgAutoloadClasses['HubOnlyRssModel'] = $dir . 'models/HubOnlyRssModel.class.php';
$wgAutoloadClasses['StarWarsDataProvider'] = $dir . 'providers/StarWarsDataProvider.class.php';

//en rss
$wgAutoloadClasses['TvRssModel']	= $dir . 'models/TvRssModel.class.php';
$wgAutoloadClasses['GamesRssModel']	= $dir . 'models/GamesRssModel.class.php';
$wgAutoloadClasses['LifestyleHubOnlyRssModel'] = $dir . 'models/LifestyleHubOnlyRssModel.class.php';
$wgAutoloadClasses['EntertainmentHubOnlyRssModel'] = $dir . 'models/EntertainmentHubOnlyRssModel.class.php';
$wgAutoloadClasses['MarvelRssModel'] = $dir . 'models/MarvelRssModel.class.php';
$wgAutoloadClasses['StarWarsRssModel'] = $dir . 'models/StarWarsRssModel.class.php';


//de rss
$wgAutoloadClasses['GamesDeHubOnlyRssModel']	= $dir . 'models/GamesDeHubOnlyRssModel.class.php';
$wgAutoloadClasses['EntertainmentDeHubOnlyRssModel']	= $dir . 'models/EntertainmentDeHubOnlyRssModel.class.php';

$wgSpecialPages['HubRssFeed']		= 'HubRssFeedSpecialController';

$wgHubRssFeedsAll = array(
	'en' => [ 'Entertainment', 'Lifestyle', 'Games', 'TV', 'Marvel', 'StarWars' ],
	'de' => [ 'Entertainment', 'Games' ]
);
$wgHubRssFeeds = $wgHubRssFeedsAll[ $wgLanguageCode ];

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
