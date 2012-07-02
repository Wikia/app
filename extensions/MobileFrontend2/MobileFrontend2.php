<?php
/**
* Extension MobileFrontend2 — Mobile Frontend 2
*
* @file
* @ingroup Extensions
*/

// Needs to be called within MediaWiki; not standalone
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MobileFrontend2',
	'version' => 1,
	'author' => 'John Du Hart',
	'descriptionmsg' => 'mobile-frontend2-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MobileFrontend2',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['MobileFrontend2'] = $dir . 'MobileFrontend2.i18n.php';

$wgAutoloadClasses['MobileFrontend2_Detection'] = $dir . 'MobileFrontend2_Detection.php';
$wgAutoloadClasses['MobileFrontend2_Hooks'] = $dir . 'MobileFrontend2_Hooks.php';
$wgAutoloadClasses['MobileFrontend2_Options'] = $dir . 'MobileFrontend2_Options.php';
$wgAutoloadClasses['MobileFrontend2_PostParse'] = $dir . 'MobileFrontend2_PostParse.php';

// Skins
$wgAutoloadClasses['SkinMobile'] = $dir . 'skins/Mobile.php';

// Hooks
$wgHooks['RequestContextCreateSkin'][] = 'MobileFrontend2_Hooks::createSkin';
$wgHooks['ParserSectionCreate'][] = 'MobileFrontend2_Hooks::parserSectionCreate';
$wgHooks['ArticleViewHeader'][] = 'MobileFrontend2_Hooks::articleView';
$wgHooks['ResourceLoaderGetStartupModules'][] = 'MobileFrontend2_Hooks::startupModule';
$wgHooks['ResourceLoaderRegisterModules'][] = 'MobileFrontend2_Hooks::registerModules';
$wgExtensionFunctions[] = 'MobileFrontend2_Hooks::setup';

// Modules
$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'MobileFrontend2/modules',
);

// Main style
$wgResourceModules['ext.mobileFrontend2'] = array(
	'scripts' => 'ext.mobileFrontend2/ext.mobileFrontend2.js',
	'messages' => array(
		'mobile-frontend2-show-button',
		'mobile-frontend2-hide-button',
	),
	'dependencies' => array(
		'mediawiki.util.lite',
		'mediawiki.api.lite',
	),
) + $commonModuleInfo;

$wgResourceModules['ext.mobileFrontend2.common'] = array(
	'styles' => 'ext.mobileFrontend2/ext.mobileFrontend2.css',
) + $commonModuleInfo;

$wgResourceModules['zepto'] = array(
	'scripts' => array(
		'zepto/zepto.js',
		'zepto/zepto.mw.js',
	),
) + $commonModuleInfo;

// Config
/**
 * Logo used on MobileFrontend2
 *
 * @var $wgMobileFrontend2Logo string
 */
$wgMobileFrontend2Logo = null;