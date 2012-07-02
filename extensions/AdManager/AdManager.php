<?php
/**
 * AdManager - a MediaWiki extension that allows setting an ad zone for
 * individual pages or categories 
 *
 * The special page created is 'Special:AdManager', which allows sysops to set
 * the zone for the pages or categories.
 * The correct ad code for adding the zone is automatically added to the
 * correct page.
 *
 * @file
 * @ingroup Extensions
 * @version 0.2
 * @author Ike Hecht
 * @link http://www.mediawiki.org/wiki/Extension:AdManager Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'AD_TABLE', 'ad' );
define( 'AD_ZONES_TABLE', 'adzones' );

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'AdManager',
	'version' => '0.2',
	'author' => 'Ike Hecht for WikiWorks',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AdManager',
	'descriptionmsg' => 'admanager-desc',
);

// Lowercase name of the advertising service. Currently supported values are:
// openx and banman
$wgAdManagerService = null;

$wgAdManagerCode = null;

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['AdManager'] = $dir . 'AdManager.i18n.php';

// This extension uses its own permission type, 'admanager'
$wgAvailableRights[] = 'admanager';
$wgGroupPermissions['sysop']['admanager'] = true;

$wgSpecialPages['AdManagerZones'] = 'SpecialAdManagerZones';
$wgSpecialPages['AdManager'] = 'SpecialAdManager';
$wgAutoloadClasses['SpecialAdManagerZones'] = $dir . 'SpecialAdManagerZones.php';
$wgAutoloadClasses['SpecialAdManager'] = $dir . 'SpecialAdManager.php';

$wgAutoloadClasses['AdManagerHooks'] = $dir . 'AdManager.hooks.php';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'AdManagerHooks::onSchemaUpdate';
$wgHooks['SkinBuildSidebar'][] = 'AdManagerHooks::SkinBuildSidebar';

$wgAutoloadClasses['AdManagerUtils'] = $dir . 'AdManager.utils.php';