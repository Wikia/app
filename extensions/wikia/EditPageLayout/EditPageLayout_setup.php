<?php

/**
 * EditPageLayout
 *
 * Applies updated layout for edit pages (Oasis only)
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/EditPageLayout/EditPageLayout_setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'EditPageLayout',
	'version' => '1.0',
	'author' => 'Maciej Brencz',
	'description' => 'Applies updated layout for edit pages',
);

$dir = dirname(__FILE__);

// classes
$wgAutoloadClasses['EditPageLayout'] =  $dir . '/EditPageLayout.class.php';
$wgAutoloadClasses['EditPageLayoutAjax'] =  $dir . '/EditPageLayoutAjax.class.php';
$wgAutoloadClasses['EditPageLayoutHelper'] =  $dir . '/EditPageLayoutHelper.class.php';
$wgAutoloadClasses['EditPageLayoutHooks'] =  $dir . '/EditPageLayoutHooks.class.php';
$wgAutoloadClasses['EditPageLayoutController'] =  $dir . '/EditPageLayoutController.class.php';

// mocks classes
$wgAutoloadClasses['ObjectMocker'] =  $dir . '/mocks/ObjectMocker.class.php';
$wgAutoloadClasses['ObjectTracer'] =  $dir . '/mocks/ObjectTracer.class.php';
$wgAutoloadClasses['ObjectCallTrace'] =  $dir . '/mocks/ObjectCallTrace.class.php';

// notices classes
$wgAutoloadClasses['EditPageNotice'] =  $dir . '/notices/EditPageNotice.class.php';
$wgAutoloadClasses['EditPageNotices'] =  $dir . '/notices/EditPageNotices.class.php';
$wgAutoloadClasses['EditPageOutputBridge'] =  $dir . '/notices/EditPageOutputBridge.class.php';

// services
$wgAutoloadClasses['EditPageService'] =  $dir . '/EditPageService.class.php';

// abstract special page class for custom edit pages
$wgAutoloadClasses['SpecialCustomEditPage'] =  $dir . '/SpecialCustomEditPage.class.php';

// hooks
$wgHooks['AlternateEditPageClass'][] = 'EditPageLayoutHooks::onAlternateEditPageClass';
$wgHooks['EditPageBeforeConflictDiff'][] = 'EditPageLayoutHooks::onEditPageBeforeConflictDiff';
$wgHooks['EditPageGetPreviewNote'][] = 'EditPageLayoutHooks::onEditPageGetPreviewNote';
$wgHooks['EditForm:AfterDisplayingTextbox'][] = 'EditPageLayoutHooks::onAfterDisplayingTextbox';
$wgHooks['EditForm:BeforeDisplayingTextbox'][] = 'EditPageLayoutHooks::onBeforeDisplayingTextbox';
$wgHooks['GetPreferences'][] = 'EditPageLayoutHooks::onGetPreferences';
$wgHooks['LogEventsListShowLogExtract'][] = 'EditPageLayoutHooks::onLogEventsListShowLogExtract';

// messages
$wgExtensionMessagesFiles['EditPageLayout'] = $dir . '/EditPageLayout.i18n.php';

// add class to autoloader and register handler for it
$wgAutoloadClasses['EditorUserPropertiesHandler'] = "$dir/models/EditorUserPropertiesHandler.class.php";
WikiaUserPropertiesController::registerHandler('EditorUserPropertiesHandler');

// register messages package for JS
JSMessages::registerPackage('EditPageLayout', array(
	'ok',
	'back',
	'preview',
	'savearticle',
	'editpagelayout-captcha-title',
	'editpagelayout-edit-info',
	'editpagelayout-more',
	'editpagelayout-less',
	'editpagelayout-pageControls-changes',
	'editpagelayout-loadingStates-*',
	'editpagelayout-modules-*',
	'wikia-editor-*',
	'restore-edits-*',
	'plb-special-form-cat-info',
	'wikia-editor-preview-current-width',
	'wikia-editor-preview-min-width',
	'wikia-editor-preview-max-width',
	'wikia-editor-preview-type-tooltip'
));

// Ajax dispatcher
$wgAjaxExportList[] = 'EditPageLayoutAjax';
function EditPageLayoutAjax() {
	global $wgRequest;
	wfProfileIn(__METHOD__);

	$ret = false;

	$method = $wgRequest->getVal('method', false);

	if ($method && method_exists('EditPageLayoutAjax', $method)) {
		$data = EditPageLayoutAjax::$method();

		if (is_array($data)) {
			$json = json_encode($data);

			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
			$ret = $response;
		}
		else {
			$ret = $data;
		}
	}

	wfProfileOut(__METHOD__);
	return $ret;
}

