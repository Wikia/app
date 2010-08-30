<?php
/**
 * Oasis
 *
 * Provides an easy way to add hooks for Oasis skin modules
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
	$wgHooks['AchievementsNotification'][] = 'NotificationsModule::addBadgeNotification';
	$wgHooks['EditSimilar::showMessage'][] = 'NotificationsModule::addEditSimilarNotification';
	$wgHooks['CommunityMessages::showMessage'][] = 'NotificationsModule::addCommunityMessagesNotification';
}

// Mapping of themename to an array of key/value pairs to send to SASS.
// Sean says: Since SASS is used to generate the CSS files, this config is all that's needed for the themes.
$wgOasisThemes = array(
	'shadesofgray' => array(
		'color-body' => '#808080',
		'color-page' => '#eeeeee',
		'color-header' => '#aaaaaa',
		'color-text' => '#000000',
		'color-buttons-links' => '#808080',
	),
	'blue' => array(
		'color-body' => '#000080',
		'color-page' => '#8080ff',
		'color-header' => '#000080',
		'color-text' => '#000000',
		'color-buttons-links' => '#0000ff',
	),
	'harvest' => array(
		'color-body' => '#FFA500',
		'color-page' => '#F5F5DC',
		'color-header' => '#FF6347',
		'color-text' => '#800080',
		'color-buttons-links' => '#008000',
	),
	'pink' => array(
		'color-body' => '#ec6868',
		'color-page' => '#ffcece',
		'color-header' => '#ff9797',
		'color-text' => '#970000',
		'color-buttons-links' => '#ff0000',
	),
	'carbon' => array(
		'color-body' => '#273423',
		'color-page' => '#474646',
		'color-buttons' => '#5c8901',
		'color-links' => '#70b8ff',
	),
	'obsession' => array(
		'color-body' => '#140000',
		'color-page' => '#1d1313',
		'color-header' => '#3f0700',
		'color-text' => '#c3c3c3',
		'color-buttons-links' => '#e51818',
	 ),
	 'jade' => array(
		 'color-body' => '#036056',
		 'color-page' => '#ffffff',
		 'color-header' => '#046242',
		 'color-text' => '#101c4e',
		 'color-buttons-links' => '#016445',
	 ),
	 'sky' => array(
		'color-body' => '#a3b6de',
		'color-page' => '#c6e2ec',
		'color-header' => '#2155ab',
		'color-text' => '#101c4e',
		'color-buttons-links' => '#019ad3',
	 ),
	 'beach' => array(
		'color-body' => '#fcf1c9',
		'color-page' => '#e8e4d7',
		'color-header' => '#2155ab',
		'color-text' => '#3b2516',
		'color-buttons-links' => '#019ad3',
	 ),
	 'forest' => array(
		'color-body' => '#6a7641',
		'color-page' => '#e8e4d7',
		'color-header' => '#4b501f',
		'color-text' => '#4b501f',
		'color-buttons-links' => '#d06803',
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
