<?php
/**
 * ShoutWiki Ads -- display Google AdSense ads on skins
 *
 * @file
 * @ingroup Extensions
 * @version 0.2
 * @date 4 September 2011
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://en.wikipedia.org/wiki/Public_domain Public domain
 * @link http://www.mediawiki.org/wiki/Extension:ShoutWiki_Ads Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Go away.' );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'ShoutWiki Ads',
	'version' => '0.2',
	'author' => 'Jack Phoenix',
	'description' => 'Delicious advertisements for everyone!',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ShoutWiki_Ads',
);

// Autoload the class so that we can actually use its functions
$wgAutoloadClasses['ShoutWikiAds'] = dirname( __FILE__ ) . '/ShoutWikiAds.class.php';

// BlueCloud was designed by StrategyWiki with ads in mind, so removing them
// from it will mess up the display, which is exactly why we don't handle
// BlueCloud ads here

// Monaco
$wgHooks['MonacoSetupSkinUserCss'][] = 'ShoutWikiAds::setupAdCSS';
$wgHooks['MonacoSidebar'][] = 'ShoutWikiAds::onMonacoSidebar';
$wgHooks['MonacoFooter'][] = 'ShoutWikiAds::onMonacoFooter';

// MonoBook
$wgHooks['BeforePageDisplay'][] = 'ShoutWikiAds::setupAdCSS';
$wgHooks['MonoBookAfterContent'][] = 'ShoutWikiAds::onMonoBookAfterContent';
$wgHooks['MonoBookAfterToolbox'][] = 'ShoutWikiAds::onMonoBookAfterToolbox';

// Truglass
$wgHooks['TruglassInContent'][] = 'ShoutWikiAds::renderTruglassAd';

// ResourceLoader support for MediaWiki 1.17+
$resourceTemplate = array(
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'ShoutWikiAds'
);

$wgResourceModules['ext.ShoutWikiAds.monaco'] = $resourceTemplate + array(
	'styles' => 'css/monaco-ads.css'
);

$wgResourceModules['ext.ShoutWikiAds.monobook.button'] = $resourceTemplate + array(
	'styles' => 'css/monobook-button-ad.css'
);

$wgResourceModules['ext.ShoutWikiAds.monobook.skyscraper'] = $resourceTemplate + array(
	'styles' => 'css/monobook-skyscraper-ad.css'
);

$wgResourceModules['ext.ShoutWikiAds.truglass'] = $resourceTemplate + array(
	'styles' => 'css/truglass-ads.css'
);

/* Configuration
$wgAdConfig = array(
	'enabled' => true, // enabled or not? :P
	'adsense-client' => '', // provider number w/o the "pub-" part
	'namespaces' => array( NS_MAIN, NS_TALK ), // array of enabled namespaces
	'right-column' => true, // do we want a skyscraper ad column (Monobook)?
	'toolbox-button' => true, // or a "button" ad below the toolbox (Monobook)?
	'monaco-sidebar' => true, // 200x200 sidebar ad in the sidebar on Monaco skin
	'monaco-leaderboard' => true, // leaderboard (728x90) ad in the footer on Monaco skin
	'truglass-leaderboard' => true, // leaderboard ad for Truglass skin
);
*/