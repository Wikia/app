<?php
/**
 * MediaWiki extension to add Google AdSense in a portlet in the sidebar.
 * Installation instructions can be found on
 * http://www.mediawiki.org/wiki/Extension:Google_AdSense_2
 *
 * This extension will not add the Google Adsense portlet to *any* skin
 * that is used with MediaWiki. Because of inconsistencies in the skin
 * implementation, it will not be add to the following skins:
 * cologneblue, standard, nostalgia
 *
 * @addtogroup Extensions
 * @author Siebrand Mazeland
 * @license MIT
 */

/**
 * Exit if called outside of MediaWiki
 */
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/**
 * SETTINGS
 * --------
 * The description of the portlet can be changed in [[MediaWiki:Googleadsense]].
 *
 * The following variables may need to be reset in your LocalSettings.php.
 * Compare them to the script output in the Google AdSense interface.
 */
$wgGoogleAdSenseWidth  = 120;    // Width of the AdSense box, specified in your AdSense account
$wgGoogleAdSenseHeight = 240;    // Width of the AdSense box, specified in your AdSense account
$wgGoogleAdSenseSrc    = "http://pagead2.googlesyndication.com/pagead/show_ads.js"; // Source URL of the AdSense script
$wgGoogleAdSenseAnonOnly = false; // Show the AdSense box only for anonymous users
//$wgGoogleAdSenseCssLocation = $wgScriptPath . '/extensions/GoogleAdSense'; // Path to GoogleAdSense.css if non-default

/**
 * The following variables must be set in your LocalSettings.php.
 * The extension will not work without it.
 */
$wgGoogleAdSenseClient = 'none'; // Client ID for your AdSense script (example: pub-1234546403419693)
$wgGoogleAdSenseSlot   = 'none'; // Slot ID for your AdSense script (example: 1234580893)
$wgGoogleAdSenseID     = 'none'; // ID for your AdSense script (example: translatewiki)

$wgExtensionCredits['other'][] = array(
	'name'           => 'Google AdSense',
	'version'        => '1.1',
	'author'         => 'Siebrand Mazeland',
	'description'    => 'Adds GoogleAdSense to the sidebar',
	'descriptionmsg' => 'googleadsense-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Google_AdSense_2',
);

// Register class and localisations
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['GoogleAdSense'] = $dir . 'GoogleAdSense.class.php';
$wgExtensionMessagesFiles['GoogleAdSense'] = $dir . 'GoogleAdSense.i18n.php';

// Hook to modify the sidebar
$wgHooks['SkinBuildSidebar'][] = 'GoogleAdSense::GoogleAdSenseInSidebar';

// Hook to inject CSS - currently disabled, because it does not add the CSS somehow
//$wgHooks['OutputPageBeforeHTML'][] = 'GoogleAdSense::injectCSS';
