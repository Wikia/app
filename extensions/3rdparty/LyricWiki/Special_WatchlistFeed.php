<?php
/**********************************************************************************

Copyright (C) 2008 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1,1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LyricWiki (http://lyrics.wikia.com/)

***********************************************************************************

Version 0.1 2008-07-26
* Created - teknomunk

*/

// Extension Credits Definition
if(isset($wgScriptPath)){
	$wgExtensionCredits["specialpage"][] = array(
	  'name' => 'Watchlist Feeds',
	  'version' => '0.0.3',
	  'url' => 'http://lyrics.wikia.com/User:Teknomunk',
	  'author' => '[http://www.seancolombo.com Sean Colombo], [http://lyrics.wikia.com/User:Teknomunk teknomunk]',
	  'description' => 'Enable User Watchlist Feeds'
	);
}

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if (!defined('MEDIAWIKI'))
{
        echo <<<EOT
<h1>Special Page: Watchlist Feeds</h1>
To install this extension, put the following line in LocalSettings.php:
require_once( "$IP/extensions/MyExtension/MyExtension.php" );
EOT;
        exit( 1 );
}

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['WatchlistFeed'] = $dir . 'Special_WatchlistFeed.body.php';
$wgExtensionMessagesFiles['WatchlistFeed'] = $dir . 'Special_WatchlistFeed.i18n.php';
$wgSpecialPages['WatchlistFeed'] = 'WatchlistFeed';

# default options
$wgWatchlistAccessKeySize = 64;

