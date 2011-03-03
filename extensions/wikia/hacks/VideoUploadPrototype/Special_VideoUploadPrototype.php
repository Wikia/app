<?php
////
// Author: Sean Colombo
// Date: 20110211
//
// Special page to test uploading videos to a third party provider and playing them.
////

if(!defined('MEDIAWIKI')) die();

// Allows anyone to view the page.
//$wgAvailableRights[] = 'videouploadprototype';
//$wgGroupPermissions['*']['videouploadprototype'] = true;
//$wgGroupPermissions['user']['videouploadprototype'] = true;
//$wgGroupPermissions['sysop']['videouploadprototype'] = true;

$wgExtensionCredits["specialpage"][] = array(
  'name' => 'Video Upload Prototype',
  'version' => '0.0.1',
  'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
  'author' => '[http://www.seancolombo.com Sean Colombo]',
  'description' => "Special page to test uploading videos to a third party provider and playing them."
);
$dir = dirname(__FILE__);
include("$dir/LongtailVideoClient.php");
$wgAutoloadClasses['VideoUploadPrototype'] = "$dir/Special_VideoUploadPrototype.body.php"; # Tell MediaWiki to load the extension body.
$wgAutoloadClasses['VideoUploadAjax'] = "$dir/VideoUploadAjax.class.php";
$wgAutoloadClasses['VideoUploadHelper'] = "$dir/VideoUploadHelper.class.php";
$wgAutoloadClasses['SpecialVideoUploadHelper'] = "$dir/SpecialVideoUploadHelper.class.php";

$wgHooks['EditPage::showEditForm:initial2'][] = 'VideoUploadHelper::setupEditPage';

// TOTAL HACK... should never be shown to end-users... no need for i18n (sorry TOR!)
//$wgExtensionMessagesFiles['VideoUploadPrototype'] = $dir . 'Special_VideoUploadPrototype.i18n.php';

$wgSpecialPages['VideoUploadPrototype'] = 'VideoUploadPrototype'; # Let MediaWiki know about your new special page.
$wgSpecialPages['VideoUploadHelper'] = 'SpecialVideoUploadHelper';

// Ajax dispatcher
$wgAjaxExportList[] = 'VideoUpload';
function VideoUpload() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('VideoUploadAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = VideoUploadAjax::$method();

		if (is_array($data)) {
			// send array as JSON
			$json = Wikia::json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}

		wfProfileOut(__METHOD__);
		return $response;
	}
}