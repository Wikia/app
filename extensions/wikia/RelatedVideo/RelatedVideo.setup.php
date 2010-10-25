<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}
/**
 *
 * @package MediaWiki
 * @subpackage RelatedVideo
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnableRelatedVideoExt = true
  */

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['RelatedVideo']		= $dir . 'RelatedVideo.body.php';
$wgAutoloadClasses['RelatedVideoRSS']		= $dir . 'RelatedVideoRSS.class.php';
$wgAutoloadClasses['RelatedVideoHelper']	= $dir . 'RelatedVideoHelper.class.php';
$wgExtensionMessagesFiles['RelatedVideo']	= $dir . 'i18n/RelatedVideo.i18n.php';
$wgAutoloadClasses['RelatedVideoModule']	= $IP.'/skins/oasis/modules/RelatedVideoModule.class.php';

$wgSpecialPages['RelatedVideo']			= 'RelatedVideo';
$wgSpecialPageGroups['RelatedVideo']		= 'wikia';

$wgHooks['AfterAdModuleExecute'][]		= 'RelatedVideoHelper::onAfterAdModuleExecute';
$wgHooks['GetRailModuleList'][]			= 'RelatedVideoHelper::onGetRailModuleList';
$wgHooks['BeforeExecuteSpotlightsIndex'][]	= 'RelatedVideoHelper::onBeforeExecuteSpotlightsIndex';
