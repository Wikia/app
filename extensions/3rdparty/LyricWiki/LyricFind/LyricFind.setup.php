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

// common code
$wgAutoloadClasses['LyricFindHooks'] =  $dir . '/LyricFindHooks.class.php';
$wgExtensionMessagesFiles['LyricFind'] = $dir . '/LyricFind.i18n.php';

// LyricFind page views tracking
$wgAutoloadClasses['LyricFindController'] =  $dir . '/LyricFindController.class.php';
$wgAutoloadClasses['LyricFindTrackingService'] =  $dir . '/LyricFindTrackingService.class.php';

$wgHooks['OasisSkinAssetGroups'][] = 'LyricFindHooks::onSkinAssetGroups';
$wgHooks['MonobookSkinAssetGroups'][] = 'LyricFindHooks::onSkinAssetGroups';
$wgHooks['WikiaMobileAssetsPackages'][] = 'LyricFindHooks::onSkinAssetGroups';

$wgLyricFindTrackingNamespaces = [NS_MAIN];

// LyricFind indexing
$wgHooks['ParserBeforeStrip'][] = 'LyricFindHooks::onParserBeforeStrip';

$wgHooks['AlternateEdit'][] = 'LyricFindHooks::onAlternateEdit';

// parser hook
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
