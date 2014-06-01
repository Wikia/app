<?php

/**
 * Provides page views counter for namespaces with lyric pages
 *
 * @author macbre
  */
$wgExtensionCredits['other'][] = array(
	'name' => 'LyricFind',
	'version' => '1.1',
	'author' => array('Maciej Brencz'),
	'description' => 'Provides page views tracking and &lt;lyricfind&gt; parser tag'
);

$dir = __DIR__;

// for backward compatibility
if (!defined('NS_GRACENOTE')) define('NS_GRACENOTE', 220);

// LyricFind namespace setup
define('NS_LYRICFIND', 222);
$wgExtraNamespaces[NS_LYRICFIND] = 'LyricFind';
$wgNamespacesWithSubpages[NS_LYRICFIND] = false;
$wgContentNamespaces[] = NS_LYRICFIND;

// common code
$wgAutoloadClasses['LyricFindHooks'] =  $dir . '/LyricFindHooks.class.php';
$wgExtensionMessagesFiles['LyricFind'] = $dir . '/LyricFind.i18n.php';

// LyricFind page views tracking
$wgAutoloadClasses['LyricFindController'] =  $dir . '/LyricFindController.class.php';
$wgAutoloadClasses['LyricFindTrackingService'] =  $dir . '/LyricFindTrackingService.class.php';

$wgHooks['OasisSkinAssetGroups'][] = 'LyricFindHooks::onSkinAssetGroups';
$wgHooks['MonobookSkinAssetGroups'][] = 'LyricFindHooks::onSkinAssetGroups';
$wgHooks['WikiaMobileAssetsPackages'][] = 'LyricFindHooks::onSkinAssetGroups';

$wgLyricFindTrackingNamespaces = [
	NS_MAIN,
	NS_GRACENOTE,
	NS_LYRICFIND
];

// LyricFind indexing
$wgHooks['BeforePageDisplay'][] = 'LyricFindHooks::onBeforePageDisplay';

// edit permissions & view-source protection
// @see http://www.mediawiki.org/wiki/Manual:$wgNamespaceProtection
$wgGroupPermissions['*']['editlyricfind'] = false;
$wgGroupPermissions['staff']['editlyricfind'] = true;
$wgNamespaceProtection[ NS_LYRICFIND ] = array('editlyricfind');

$wgHooks['AlternateEdit'][] = 'LyricFindHooks::onAlternateEdit';

// parser hhok
$wgHooks['ParserFirstCallInit'][] = 'LyricFindHooks::onParserFirstCallInit';
$wgHooks['ParserAfterTidy'][] = 'LyricFindHooks::onParserAfterTidy';
$wgAutoloadClasses['LyricFindParserController'] =  $dir . '/LyricFindParserController.class.php';

// front-end for pages with lyrics
$wgResourceModules['ext.lyrics.lyricbox'] = array(
	'scripts' => 'js/lyricbox.js',
	'styles' => 'css/lyricbox.css',
	'dependencies' => array(
		'amd',
		'wikia.mw',
	),
	'localBasePath' => __DIR__,
	'remoteExtPath' => '3rdparty/LyricWiki/LyricFind'
);
