<?php
/**
 * Game Guides API setup file
 * 
 * @author Federico "Lox" Lucignano
 */
 
$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'Game Guides',
	'author' => 'Federico "Lox" Lucignano',
	'descriptionmsg' => 'wikiagameguides-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GameGuides',
);

$dir = dirname( __FILE__ );

/**
 * classes
 */
$wgAutoloadClasses['GameGuidesController'] = "{$dir}/GameGuidesController.class.php";
$wgAutoloadClasses['GameGuidesWrongAPIVersionException'] = "{$dir}/GameGuidesController.class.php";
$wgAutoloadClasses['GameGuidesModel'] =  "{$dir}/GameGuidesModel.class.php" ;

/**
 * message files
 */
$wgExtensionMessagesFiles['GameGuides'] = "{$dir}/GameGuides.i18n.php";


//Special Page to preview page in GameGuide style
$wgAutoloadClasses['GameGuidesSpecialPreviewController'] =  "{$dir}/GameGuidesSpecialPreviewController.class.php" ;
$wgSpecialPages['GameGuidesPreview'] = 'GameGuidesSpecialPreviewController';

$wgGroupPermissions['*']['gameguidespreview'] = false;
$wgGroupPermissions['staff']['gameguidespreview'] = true;
$wgGroupPermissions['sysop']['gameguidespreview'] = true;

//Special Page for Content Managment Tool
$wgAutoloadClasses[ 'GameGuidesSpecialContentController'] =  "{$dir}/GameGuidesSpecialContentController.class.php" ;
$wgSpecialPages[ 'GameGuidesContent' ] =  'GameGuidesSpecialContentController';

$wgGroupPermissions['*']['gameguidescontent'] = false;
$wgGroupPermissions['staff']['gameguidescontent'] = true;
$wgGroupPermissions['helper']['gameguidescontent'] = true;

if ( $wgGameGuidesContentForAdmins ) {
	$wgGroupPermissions['sysop']['gameguidescontent'] = true;
}

$wgGroupPermissions['*']['gameguidescontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['gameguidescontent-switchforadmins'] = true;

JSMessages::registerPackage( 'GameGuidesContentMsg', [
	'wikiagameguides-content-category',
	'wikiagameguides-content-tag',
	'wikiagameguides-content-name',
	'wikiagameguides-content-duplicate-entry',
	'wikiagameguides-content-category-error',
	'wikiagameguides-content-required-entry',
	'wikiagameguides-content-empty-tag'
] );

//Special Page for Sponsored Videos Managment Tool
$wgAutoloadClasses['GameGuidesSpecialSponsoredController'] = "{$dir}/GameGuidesSpecialSponsoredController.class.php";
$wgSpecialPages['GameGuidesSponsored'] ='GameGuidesSpecialSponsoredController';

$wgGroupPermissions['*']['gameguidessponsored'] = false;
$wgGroupPermissions['staff']['gameguidessponsored'] = true;

JSMessages::registerPackage( 'GameGuidesSponsoredMsg', [
	'wikiagameguides-sponsored-video',
	'wikiagameguides-sponsored-language',
	'wikiagameguides-sponsored-video-title',
	'wikiagameguides-sponsored-duplicate-entry',
	'wikiagameguides-sponsored-required-entry',
	'wikiagameguides-sponsored-empty-language',
	'wikiagameguides-sponsored-orphaned-video',
	'wikiagameguides-sponsored-delete-videos-are-you-sure',
	'wikiagameguides-sponsored-video-does-not-exist',
	'wikiagameguides-sponsored-video-is-not-ooyala'
] );

//hooks
$wgHooks['GameGuidesContentSave'][] = 'GameGuidesController::onGameGuidesContentSave';
$wgHooks['GameGuidesSponsoredVideosSave'][] = 'GameGuidesController::onGameGuidesSponsoredSave';
$wgHooks['TitleGetSquidURLs'][] = 'GameGuidesController::onTitleGetSquidURLs';
//add Game Guides Content to WikiFeatures
$wgHooks['WikiFeatures::onGetFeatureNormal'][] = 'GameGuidesSpecialContentController::onWikiFeatures';
$wgHooks['WikiFeatures::onToggleFeature'][] = 'GameGuidesSpecialContentController::onWikiFeatures';

//minimal package of messages in Game Gudes
JSMessages::registerPackage( 'GameGuides', array(
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
) );