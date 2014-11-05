<?php
/**
 * Game Guides API setup file
 * 
 * @author Federico "Lox" Lucignano
 */
$dir = dirname( __FILE__ );

/**
 * classes
 */
$wgAutoloadClasses['CuratedContentController'] = "{$dir}/CuratedContentController.class.php";
$wgAutoloadClasses['CuratedContentWrongAPIVersionException'] = "{$dir}/CuratedContentController.class.php";
$wgAutoloadClasses['CuratedContentModel'] =  "{$dir}/CuratedContentModel.class.php" ;

/**
 * message files
 */
$wgExtensionMessagesFiles['CuratedContent'] = "{$dir}/CuratedContent.i18n.php";


//Special Page to preview page in GameGuide style
$wgAutoloadClasses['CuratedContentSpecialPreviewController'] =  "{$dir}/CuratedContentSpecialPreviewController.class.php" ;
$wgSpecialPages['CuratedContentPreview'] = 'CuratedContentSpecialPreviewController';

$wgGroupPermissions['*']['CuratedContentpreview'] = false;
$wgGroupPermissions['staff']['CuratedContentpreview'] = true;
$wgGroupPermissions['sysop']['CuratedContentpreview'] = true;

//Special Page for Content Managment Tool
$wgAutoloadClasses[ 'CuratedContentSpecialContentController'] =  "{$dir}/CuratedContentSpecialContentController.class.php" ;
$wgSpecialPages[ 'CuratedContentContent' ] =  'CuratedContentSpecialContentController';

$wgGroupPermissions['*']['CuratedContentcontent'] = false;
$wgGroupPermissions['staff']['CuratedContentcontent'] = true;
$wgGroupPermissions['helper']['CuratedContentcontent'] = true;

if ( $wgCuratedContentContentForAdmins ) {
	$wgGroupPermissions['sysop']['CuratedContentcontent'] = true;
}

$wgGroupPermissions['*']['CuratedContentcontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['CuratedContentcontent-switchforadmins'] = true;

JSMessages::registerPackage( 'CuratedContentContentMsg', [
	'wikiaCuratedContent-content-category',
	'wikiaCuratedContent-content-tag',
	'wikiaCuratedContent-content-name',
	'wikiaCuratedContent-content-duplicate-entry',
	'wikiaCuratedContent-content-category-error',
	'wikiaCuratedContent-content-required-entry',
	'wikiaCuratedContent-content-empty-tag'
] );

//Special Page for Sponsored Videos Managment Tool
$wgAutoloadClasses['CuratedContentSpecialSponsoredController'] = "{$dir}/CuratedContentSpecialSponsoredController.class.php";
$wgSpecialPages['CuratedContentSponsored'] ='CuratedContentSpecialSponsoredController';

$wgGroupPermissions['*']['CuratedContentsponsored'] = false;
$wgGroupPermissions['staff']['CuratedContentsponsored'] = true;

JSMessages::registerPackage( 'CuratedContentSponsoredMsg', [
	'wikiaCuratedContent-sponsored-video',
	'wikiaCuratedContent-sponsored-language',
	'wikiaCuratedContent-sponsored-video-title',
	'wikiaCuratedContent-sponsored-duplicate-entry',
	'wikiaCuratedContent-sponsored-required-entry',
	'wikiaCuratedContent-sponsored-empty-language',
	'wikiaCuratedContent-sponsored-orphaned-video',
	'wikiaCuratedContent-sponsored-delete-videos-are-you-sure',
	'wikiaCuratedContent-sponsored-video-does-not-exist',
	'wikiaCuratedContent-sponsored-video-is-not-ooyala'
] );

//hooks
$wgHooks['CuratedContentContentSave'][] = 'CuratedContentController::onCuratedContentContentSave';
$wgHooks['CuratedContentSponsoredVideosSave'][] = 'CuratedContentController::onCuratedContentSponsoredSave';
$wgHooks['TitleGetSquidURLs'][] = 'CuratedContentController::onTitleGetSquidURLs';
//add Game Guides Content to WikiFeatures
$wgHooks['WikiFeatures::onGetFeatureNormal'][] = 'CuratedContentSpecialContentController::onWikiFeatures';
$wgHooks['WikiFeatures::onToggleFeature'][] = 'CuratedContentSpecialContentController::onWikiFeatures';

//minimal package of messages in Game Gudes
JSMessages::registerPackage( 'CuratedContent', array(
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
) );