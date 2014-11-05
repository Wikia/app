<?php
/**
 * Curated Content API setup file
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


//Special Page to preview page in Curated Content style
$wgAutoloadClasses['CuratedContentSpecialPreviewController'] =  "{$dir}/CuratedContentSpecialPreviewController.class.php" ;
$wgSpecialPages['CuratedContentPreview'] = 'CuratedContentSpecialPreviewController';

$wgGroupPermissions['*']['curatedcontentpreview'] = false;
$wgGroupPermissions['staff']['curatedcontentpreview'] = true;
$wgGroupPermissions['sysop']['curatedcontentpreview'] = true;

//Special Page for Content Managment Tool
$wgAutoloadClasses[ 'CuratedContentSpecialController'] =  "{$dir}/CuratedContentSpecialController.class.php" ;
$wgSpecialPages[ 'CuratedContent' ] =  'CuratedContentSpecialController';

$wgGroupPermissions['*']['curatedcontent'] = false;
$wgGroupPermissions['staff']['curatedcontent'] = true;
$wgGroupPermissions['helper']['curatedcontent'] = true;

if ( $wgCuratedContentForAdmins ) {
	$wgGroupPermissions['sysop']['curatedcontent'] = true;
}

$wgGroupPermissions['*']['curatedcontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['curatedcontent-switchforadmins'] = true;

JSMessages::registerPackage( 'CuratedContentMsg', [
	'wikiacuratedcontent-content-category',
	'wikiacuratedcontent-content-tag',
	'wikiacuratedcontent-content-name',
	'wikiacuratedcontent-content-duplicate-entry',
	'wikiacuratedcontent-content-category-error',
	'wikiacuratedcontent-content-required-entry',
	'wikiacuratedcontent-content-empty-tag'
] );

JSMessages::registerPackage( 'CuratedContentSponsoredMsg', [
	'wikiacuratedcontent-sponsored-video',
	'wikiacuratedcontent-sponsored-language',
	'wikiacuratedcontent-sponsored-video-title',
	'wikiacuratedcontent-sponsored-duplicate-entry',
	'wikiacuratedcontent-sponsored-required-entry',
	'wikiacuratedcontent-sponsored-empty-language',
	'wikiacuratedcontent-sponsored-orphaned-video',
	'wikiacuratedcontent-sponsored-delete-videos-are-you-sure',
	'wikiacuratedcontent-sponsored-video-does-not-exist',
	'wikiacuratedcontent-sponsored-video-is-not-ooyala'
] );

//hooks
$wgHooks['CuratedContentSave'][] = 'CuratedContentController::onCuratedContentSave';
$wgHooks['CuratedContentSponsoredVideosSave'][] = 'CuratedContentController::onCuratedContentSponsoredSave';
$wgHooks['TitleGetSquidURLs'][] = 'CuratedContentController::onTitleGetSquidURLs';
//add Curated Content to WikiFeatures
$wgHooks['WikiFeatures::onGetFeatureNormal'][] = 'CuratedContentSpecialController::onWikiFeatures';
$wgHooks['WikiFeatures::onToggleFeature'][] = 'CuratedContentSpecialController::onWikiFeatures';

//minimal package of messages in CuratedContent
JSMessages::registerPackage( 'CuratedContent', [
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
] );
