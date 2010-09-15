<?php
/**
 * Oasis
 *
 * Provides an easy way to add hooks for Oasis skin modules
 *
 * @author Maciej Brencz
 */

$wgExtensionFunctions[] = 'wfOasisSetup';

function wfOasisSetup() {
	global $wgHooks;

	$wgHooks['ArticleSaveComplete'][] = 'PageStatsService::onArticleSaveComplete';
	$wgHooks['ArticleDeleteComplete'][] = 'PageStatsService::onArticleDeleteComplete';
	$wgHooks['ArticleSaveComplete'][] = 'UserStatsService::onArticleSaveComplete';
	$wgHooks['BlogTemplateGetResults'][] = 'BlogListingModule::getResults';
	$wgHooks['BlogsRenderBlogArticlePage'][] = 'BlogListingModule::renderBlogListing';
	$wgHooks['EditPage::showEditForm:initial'][] = 'BodyModule::onEditPageRender';
	$wgHooks['EditPage::showEditForm:initial'][] = 'PageHeaderModule::modifyEditPage';
	$wgHooks['MakeThumbLink2'][] = 'ContentDisplayModule::renderPictureAttribution';

	// confirmations
	$wgHooks['PreferencesMainPrefsForm'][] = 'NotificationsModule::addPreferencesConfirmation';
	$wgHooks['SpecialMovepageAfterMove'][] = 'NotificationsModule::addPageMovedConfirmation';
	$wgHooks['ArticleDeleteComplete'][] = 'NotificationsModule::addPageDeletedConfirmation';
	$wgHooks['ArticleUndelete'][] = 'NotificationsModule::addPageUndeletedConfirmation';
	$wgHooks['UserLogoutComplete'][] = 'NotificationsModule::addLogOutConfirmation';
	$wgHooks['SkinTemplatePageBeforeUserMsg'][] = 'NotificationsModule::addFacebookConnectConfirmation';

	// notifications
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'NotificationsModule::addMessageNotification';
	$wgHooks['AchievementsNotification'][] = 'NotificationsModule::addBadgeNotification';
	$wgHooks['EditSimilar::showMessage'][] = 'NotificationsModule::addEditSimilarNotification';
	$wgHooks['CommunityMessages::showMessage'][] = 'NotificationsModule::addCommunityMessagesNotification';
}

// Mapping of themename to an array of key/value pairs to send to SASS.
// Sean says: Since SASS is used to generate the CSS files, this config is all that's needed for the themes.
$wgOasisThemes = array(
	'oasis' => array(
		"color-body" => "#BACDD8",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#006CB0",
		"color-links" => "#006CB0",
		"background-image" => "oasis.png",
		"background-tiled" => true
	),
	'sapphire' => array(
		"color-body" => "#2B54B5",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#0038D8",
		"color-links" => "#0148C2",
		"background-image" => "sapphire.png",
		"background-tiled" => false
	),
	'jade' => array(
		"color-body" => "#003816",
		"color-page" => "#DFDBC3",
		"color-buttons" => "#C5A801",
		"color-links" => "#BE6202",
		"background-image" => "",
		"background-tiled" => false
	),
	'sky' => array(
		"color-body" => "#BDEAFD",
		"color-page" => "#DEF4FE",
		"color-buttons" => "#F9CE3A",
		"color-links" => "#285BAF",
		"background-image" => "sky.png",
		"background-tiled" => false
	),
	'moonlight' => array(
		"color-body" => "#000000",
		"color-page" => "#CCD9F9",
		"color-buttons" => "#6F027C",
		"color-links" => "#6F027C",
		"background-image" => "moonlight.jpg",
		"background-tiled" => false
	),
	'opulence' => array(
		"color-body" => "#7A0146",
		"color-page" => "#36001F",
		"color-buttons" => "#DE1C4E",
		"color-links" => "#F97EC4",
		"background-image" => "opulence.png",
		"background-tiled" => true
	),
	'obsession' => array(
		"color-body" => "#191919",
		"color-page" => "#1C0400",
		"color-buttons" => "#891100",
		"color-links" => "#FF6F1E",
		"background-image" => "",
		"background-tiled" => true
	),
	'carbon' => array(
		"color-body" => "#1A1A1A",
		"color-page" => "#474646",
		"color-buttons" => "#012E59",
		"color-links" => "#70B8FF",
		"background-image" => "carbon.png",
		"background-tiled" => false
	),
	'beach' => array(
		"color-body" => "#97E4FE",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#C2D04D",
		"color-links" => "#FE7801",
		"background-image" => "beach.png",
		"background-tiled" => true
	),
	'dragstrip' => array(
		"color-body" => "#353637",
		"color-page" => "#0C0C0C",
		"color-buttons" => "#30A900",
		"color-links" => "#FFF000",
		"background-image" => "dragstrip.jpg",
		"background-tiled" => true
	),
	'aliencrate' => array(
		"color-body" => "#484534",
		"color-page" => "#C6C5C0",
		"color-buttons" => "#653F03",
		"color-links" => "#02899D",
		"background-image" => "aliencrate.jpg",
		"background-tiled" => false
	),
);

// AJAX dispatcher
$wgAjaxExportList[] = 'moduleProxy';
function moduleProxy() {
	wfProfileIn(__METHOD__);

	global $wgRequest;

	$outputType = $wgRequest->getVal('outputType'); // html or data

	$moduleName = $wgRequest->getVal('moduleName');
	$actionName = $wgRequest->getVal('actionName', 'Index');
	$moduleParams = json_decode($wgRequest->getVal('moduleParams'), true);

	if($outputType == 'html') {

		$response = new AjaxResponse(wfRenderModule($moduleName, $actionName, $moduleParams));
		$response->setContentType('text/html; charset=utf-8');

	} else if($outputType == 'data') {

		$response = new AjaxResponse(json_encode(Module::get($moduleName, $actionName, $moduleParams)->getData()));
		$response->setContentType('application/json; charset=utf-8');

	}

	wfProfileOut(__METHOD__);
	return $response;
}
