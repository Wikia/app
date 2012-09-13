<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'AutoHubsPages',
	'author' => 'Tomasz Odrobny',
	'url' => '',
	'description' => 'auto hubs page for wikia.com',
	'descriptionmsg' => 'myextension-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['AutoHubsPagesHelper']  = $dir . 'AutoHubsPagesHelper.class.php';
$wgAutoloadClasses['AutoHubsPagesData']  = $dir . 'AutoHubsPagesData.class.php';
$wgAutoloadClasses['AutoHubsPagesArticle']  = $dir . 'AutoHubsPagesArticle.class.php';

/* for no corporate wiki */

$wgAutoloadClasses['CorporatePageHelper']  = $dir . '../CorporatePage/CorporatePageHelper.class.php';


$wgExtensionMessagesFiles['AutoHubsPages'] = $dir . 'AutoHubsPages.i18n.php';

$wgHooks[ "ArticleFromTitle" ][] = "AutoHubsPagesArticle::ArticleFromTitle";
$wgHooks['CorporateBeforeRedirect'][] = 'AutoHubsPagesHelper::beforeRedirect';
$wgHooks['CorporateBeforeMsgCacheClear'][] = 'AutoHubsPagesHelper::beforeMsgCacheClear';
$wgAjaxExportList[] = 'AutoHubsPagesHelper::setHubsFeedsVariable';
$wgAjaxExportList[] = 'AutoHubsPagesHelper::hideFeed';

//@TODO remove wfAdProviderDARTFirstChunkForHubs, duplicated in /extensions/wikia/AdEngine/AdConfig.js
$wgHooks["AdProviderDARTFirstChunk"][] = "wfAdProviderDARTFirstChunkForHubs";

/**
 * @param string $first_chunk
 * @return bool
 */
function wfAdProviderDARTFirstChunkForHubs(&$first_chunk) {
	global $wgTitle;

	if( !AutoHubsPagesHelper::isHubsPage( $wgTitle ) ) {
		return true;
	}

	$first_chunk = 'wka.'.AutoHubsPagesHelper::getSiteForHub($wgTitle).'/_'.AutoHubsPagesHelper::getHubNameFromTitle($wgTitle).'/hub';

	return true;
}

$wgHooks['MakeGlobalVariablesScript'][] = 'wfAutoHubsPagesSetupJSVars';
function wfAutoHubsPagesSetupJSVars(Array &$vars) {
	global $wgHubsPages, $wgContLanguageCode;

	$vars['wgHubsPages'] = $wgHubsPages[$wgContLanguageCode];

	return true;
}
