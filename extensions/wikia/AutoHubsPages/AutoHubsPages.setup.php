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
function wfAdProviderDARTFirstChunkForHubs($first_chunk) {
	global $wgTitle, $wgHubsPages;

	if( !AutoHubsPagesHelper::isHubsPage( $wgTitle ) ) {
		return true;
	}

	// ANY CHANGE TO THESE HUBS MUST BE REPLICATED IN /extensions/wikia/AdEngine/AdConfig.js
	switch ($wgTitle->getUserCaseDBKey()) {
		case 'Entertainment':
		case 'Movie':
		case 'TV':
		case 'Music':
		case 'Animation':
		case 'Anime':
		case 'Sci-Fi':
		case 'Horror':
			$site = 'ent';
			break;
		case 'Gaming':
		case 'PC_Games':
		case 'Xbox_360_Games':
		case 'PS3_Games':
		case 'Wii_Games':
		case 'Handheld_Games':
		case 'Casual_Games':
		case 'Mobile_Games':
			$site = 'gaming';
			break;
		case 'Lifestyle':
		case 'Recipes':
			$site = 'life';
			break;
		default:
			$site = 'wikia';
	}

	$first_chunk = 'wka.'.$site.'/_'.AutoHubsPagesHelper::getHubNameFromTitle($wgTitle).'/hub';

	return true;
}

$wgHooks['MakeGlobalVariablesScript'][] = 'wfAutoHubsPagesSetupJSVars';
function wfAutoHubsPagesSetupJSVars($vars) {
	global $wgHubsPages, $wgContLanguageCode;

	$vars['wgHubsPages'] = $wgHubsPages[$wgContLanguageCode];

	return true;
}
