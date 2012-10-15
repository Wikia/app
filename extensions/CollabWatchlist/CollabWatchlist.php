<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the CollabWatchlist extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/CollabWatchlist/CollabWatchlist.php" );
EOT;
	exit( 1 );
}

/**
 * Toggles the recursive category scan. If you disable that, users
 * will not be able to watch edits on pages belonging to subcategories
 * of categories on their collaborative watchlist.
 * You might want to disable that, as it causes quite a bit of database
 * and (if enabled) cache load and size.
 */
$wgCollabWatchlistRecursiveCatScan = true;
/**
 * The depth of the category tree we are building.
 * This is only relevant if $wgCollabWatchlistRecursiveCatScan is enabled
 * -1 means infinite
 * 0 fetches no child categories at all
 */
$wgCollabWatchlistRecursiveCatMaxDepth = -1;
/**
 * The name of the page to show to users who don't have the necessary
 * privileges to show a page belonging to this extension.
 */
$wgCollabWatchlistPermissionDeniedPage = 'CollabWatchlistPermissionDenied';

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'CollabWatchlist',
	'author' => 'Florian Hackenberger',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CollabWatchlist',
	'descriptionmsg' => 'collabwatchlist-desc',
	'version' => '0.9.0',
);

# Autoload our classes
$wgDir = dirname( __FILE__ ) . '/';
$wgCollabWatchlistIncludes = $wgDir . 'includes/';
$wgExtensionMessagesFiles['CollabWatchlist'] = $wgDir . 'CollabWatchlist.i18n.php';
$wgExtensionMessagesFiles['CollabWatchlistAlias'] = $wgDir . 'CollabWatchlist.alias.php';

$wgAutoloadClasses['CollabWatchlistHooks'] = "$wgDir/CollabWatchlist.hooks.php";
$wgAutoloadClasses['CollabWatchlist'] = "$wgDir/CollabWatchlist.class.php";
$wgAutoloadClasses['SpecialCollabWatchlist'] = $wgCollabWatchlistIncludes . 'SpecialCollabWatchlist.php';
$wgAutoloadClasses['CollabWatchlistChangesList'] = $wgCollabWatchlistIncludes . 'CollabWatchlistChangesList.php';
$wgAutoloadClasses['CategoryTreeManip'] = $wgCollabWatchlistIncludes . 'CategoryTreeManip.php';
$wgAutoloadClasses['CollabWatchlistEditor'] = $wgCollabWatchlistIncludes . 'CollabWatchlistEditor.php';

$wgResourceModules['ext.CollabWatchlist'] = array(
        'scripts' => array( 'js/CollabWatchlist.js' ),
 
        // ResourceLoader needs to know where your files are; specify your
        // subdir relative to "/extensions" (or $wgExtensionAssetsPath)
        'localBasePath' => dirname( __FILE__ ),
        'remoteExtPath' => 'CollabWatchlist',
	'position' => 'top',
);

$wgSpecialPages['Collabwatchlist'] = 'SpecialCollabWatchlist'; # Let MediaWiki know about your new special page.
$wgSpecialPageGroups['Collabwatchlist'] = 'other';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'CollabWatchlistHooks::onLoadExtensionSchemaUpdates';
$wgHooks['GetPreferences'][] = 'CollabWatchlistHooks::onGetPreferences';
$wgHooks['UnitTestsList'][] = 'CollabWatchlistHooks::onUnitTestsList';
