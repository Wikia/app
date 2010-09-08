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

$wgHooks["AdProviderDARTFirstChunk"][] = "wfAdProviderDARTFirstChunkForHubs";
function wfAdProviderDARTFirstChunkForHubs($first_chunk) {
	global $wgTitle;

	if( !AutoHubsPagesHelper::isHubsPage( $wgTitle ) ) {
		return true;
	}

	switch ($wgTitle->getText()){
		case "Entertainment":  $first_chunk = "wka.ent/_entertainment/hub"; break;
		case "Movies":         $first_chunk = "wka.ent/_movies/hub";        break;
		case "Television":     $first_chunk = "wka.ent/_tv/hub";            break;
		case "Music":          $first_chunk = "wka.ent/_music/hub";         break;
		case "Anime":          $first_chunk = "wka.ent/_anime/hub";         break;
		case "Sci-Fi":         $first_chunk = "wka.ent/_scifi/hub";         break;
		case "Horror":         $first_chunk = "wka.ent/_horror/hub";        break;
		case "Gaming":         $first_chunk = "wka.gaming/_gaming/hub";     break;
		case "PC Games":       $first_chunk = "wka.gaming/_pcgaming/hub";   break;
		case "Xbox 360 Games": $first_chunk = "wka.gaming/_xbox360/hub";    break;
		case "PS3 Games":      $first_chunk = "wka.gaming/_ps3/hub";        break;
		case "Wii Games":      $first_chunk = "wka.gaming/_wii/hub";        break;
		case "Handheld":       $first_chunk = "wka.gaming/_handheld/hub";   break;
		case "Lifestyle":      $first_chunk = "wka.life/_lifestyle/hub";    break;

		default:               $first_chunk = "wka.wikia/_wikiaglobal/hub";
	}

	return true;
}

$wgHubsPages['en'] = array(
			'handheld_games' => 'handheld',
			'pc_games' => 'pc',
			'xbox_360_games' => 'xbox360',
			'ps3_games' => 'ps3',
			'mobile_games' => 'mobile',
			'movie' => 'movie',
			'tv' => 'tv',
			'entertainment' => 'entertainment',
			'music' => 'music',
			'animation' => 'anime',
			'anime' => 'anime',
			'music' => 'music',
			'sci-fi' => 'sci_fi',
			'horror' => 'horror',
			'gaming' => 'gaming',
			'lifestyle' => 'lifestyle',
			'wii_games' => 'wii',
			'pl' => array( 'name' => 'pl','langcode' => 'pl' )
);

$wgHubsPages['de'] = array(
			'music' => 'music',
			'travel' => 'travel',
			'sports' => 'sports',
			'green' => 'green',
			'technology' => 'technology',
			'lifestyle' => 'lifestyle',
			'politics' => 'politics',
			'entertainment' => 'entertainment',
			'education' => 'education',
			'finance' => 'finance',
			'science' => 'science',
			'creative' => 'creative',
			'auto' => 'auto',
			'toys' => 'toys',
			'humor' => 'humor',
			'wikianswers' => 'wikianswers'
);