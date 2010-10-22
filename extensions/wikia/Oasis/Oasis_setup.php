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

	$wgHooks['ArticleDeleteComplete'][] = 'PageStatsService::onArticleDeleteComplete';
	$wgHooks['ArticleSaveComplete'][] = 'LatestActivityModule::onArticleSaveComplete';
	$wgHooks['ArticleSaveComplete'][] = 'PageHeaderModule::onArticleSaveComplete';
	$wgHooks['ArticleSaveComplete'][] = 'PageStatsService::onArticleSaveComplete';
	$wgHooks['ArticleSaveComplete'][] = 'UserStatsService::onArticleSaveComplete';
	$wgHooks['BlogTemplateGetResults'][] = 'BlogListingModule::getResults';
	$wgHooks['BlogsRenderBlogArticlePage'][] = 'BlogListingModule::renderBlogListing';
	$wgHooks['EditPage::showEditForm:initial'][] = 'BodyModule::onEditPageRender';
	$wgHooks['EditPage::showEditForm:initial'][] = 'PageHeaderModule::modifyEditPage';
	$wgHooks['FileDeleteComplete'][] = 'LatestPhotosModule::onImageDelete';
	$wgHooks['MakeThumbLink2'][] = 'ContentDisplayModule::renderPictureAttribution';
	$wgHooks['MessageCacheReplace'][] = 'LatestPhotosModule::onMessageCacheReplace';
	$wgHooks['UploadComplete'][] = 'LatestPhotosModule::onImageUpload';

	// confirmations
	$wgHooks['PreferencesMainPrefsForm'][] = 'NotificationsModule::addPreferencesConfirmation';
	$wgHooks['SpecialMovepageAfterMove'][] = 'NotificationsModule::addPageMovedConfirmation';
	$wgHooks['ArticleDeleteComplete'][] = 'NotificationsModule::addPageDeletedConfirmation';
	$wgHooks['ArticleUndelete'][] = 'NotificationsModule::addPageUndeletedConfirmation';
	$wgHooks['UserLogoutComplete'][] = 'NotificationsModule::addLogOutConfirmation';
	$wgHooks['SkinTemplatePageBeforeUserMsg'][] = 'NotificationsModule::addFacebookConnectConfirmation';

	// notifications
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'NotificationsModule::addMessageNotification';
	$wgHooks['SiteWideMessagesNotification'][] = 'NotificationsModule::addSiteWideMessageNotification';
	$wgHooks['AchievementsNotification'][] = 'NotificationsModule::addBadgeNotification';
	$wgHooks['EditSimilar::showMessage'][] = 'NotificationsModule::addEditSimilarNotification';
	$wgHooks['CommunityMessages::showMessage'][] = 'NotificationsModule::addCommunityMessagesNotification';

	$wgHooks['UploadVerification'][] = 'Oasis_UploadVerification';

	// support "noexternals" URL param
	global $wgNoExternals, $wgRequest;
	$wgNoExternals = $wgRequest->getBool('noexternals');
	
	// messages
	wfLoadExtensionMessages('Oasis');
}

function Oasis_UploadVerification($destName, $tempPath, &$error) {
	$destName = strtolower($destName);
	if($destName == 'wiki-wordmark.png' || $destName == 'wiki-background') {
		return false;
	}
	return true;
}

// Mapping of themename to an array of key/value pairs to send to SASS.
// Sean says: Since SASS is used to generate the CSS files, this config is all that's needed for the themes.

global $wgCdnStylePath;

$wgOasisThemes = array(
	'oasis' => array(
		"color-body" => "#BACDD8",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#006CB0",
		"color-links" => "#006CB0",
		"color-header" => "#3A5766",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/oasis.png",
		"background-align" => "center",
		"background-tiled" => "true"
	),
	'jade' => array(
		"color-body" => "#003816",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#25883D",
		"color-links" => "#2B54B5",
		"color-header" => "#002C11",
		"background-image" => "",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'babygirl' => array(
		"color-body" => "#381B29",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#6F027C",
		"color-links" => "#6F027C",
		"color-header" => "#2A1124",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/babygirl.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'carbon' => array(
		"color-body" => "#1A1A1A",
		"color-page" => "#474646",
		"color-buttons" => "#012E59",
		"color-links" => "#70B8FF",
		"color-header" => "#012E59",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/carbon.png",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'rockgarden' => array(
		"color-body" => "#525833",
		"color-page" => "#DFDBC3",
		"color-buttons" => "#1F5D04",
		"color-links" => "#1F5D04",
		"color-header" => "#04180C",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/rockgarden.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'opulence' => array(
		"color-body" => "#AD3479",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#DE1C4E",
		"color-links" => "#810484",
		"color-header" => "#610038",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/opulence.png",
		"background-align" => "center",
		"background-tiled" => "true"
	),
	'bluesteel' => array(
		"color-body" => "#303641",
		"color-page" => "#FFFFFF",
		"color-buttons" => "#0A3073",
		"color-links" => "#0A3073",
		"color-header" => "#0A3073",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/bluesteel.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'creamsicle' => array(
		"color-body" => "#F8E9AE",
		"color-page" => "#FBE7B5",
		"color-buttons" => "#FE7E03",
		"color-links" => "#AF4200",
		"color-header" => "#A1774F",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/creamsicle.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'plated' => array(
		"color-body" => "#060606",
		"color-page" => "#474646",
		"color-buttons" => "#092F71",
		"color-links" => "#FFD500",
		"color-header" => "#000000",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/plated.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'police' => array(
		"color-body" => "#1A1A1A",
		"color-page" => "#0F142F",
		"color-buttons" => "#1A52AC",
		"color-links" => "#D6AD0B",
		"color-header" => "#181010",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/police.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
	),
	'aliencrate' => array(
		"color-body" => "#484534",
		"color-page" => "#DAD5CB",
		"color-buttons" => "#653F03",
		"color-links" => "#02899D",
		"color-header" => "#433E1F",
		"background-image" => $wgCdnStylePath ."/skins/oasis/images/themes/aliencrate.jpg",
		"background-align" => "center",
		"background-tiled" => "false"
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

// Messages
$wgExtensionMessagesFiles['Oasis'] = dirname(__FILE__) . '/Oasis.i18n.php';