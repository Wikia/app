<?php
/**
 * VideoUpload
 *
 * A VideoUpload extension for MediaWiki
 * Alows to upload video files to Longtail servers
 *
 * @author Sean Colombo
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-03-01
 * @copyright Copyright (C) 2011 Sean Colombo, Wikia Inc.
 * @copyright Copyright (C) 2011 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/hacks/VideoUploadPrototype/Special_VideoUploadPrototype.php");
 * plus required
 *     include("$IP/extensions/wikia/YouTube/YouTube.php");
 */

if(!defined('MEDIAWIKI')) die();

$wgExtensionCredits['other'][] = array(
	'name' => 'Video Upload Prototype',
	'version' => '0.1.0',
	'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	'author' => array(
		'[http://www.seancolombo.com Sean Colombo]',
		'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'description' => "Special page to test uploading videos to a third party provider and playing them."
);
$dir = dirname(__FILE__);

include("$dir/LongtailVideoClient.php");

$wgAutoloadClasses['VideoUploadPrototype'] = "$dir/Special_VideoUploadPrototype.body.php";
$wgAutoloadClasses['VideoUploadAjax'] = "$dir/VideoUploadAjax.class.php";
$wgAutoloadClasses['VideoUploadHelper'] = "$dir/VideoUploadHelper.class.php";
$wgAutoloadClasses['SpecialVideoUploadHelper'] = "$dir/SpecialVideoUploadHelper.class.php";

$wgHooks['EditPage::showEditForm:initial2'][] = 'VideoUploadHelper::setupEditPage';

// TOTAL HACK... should never be shown to end-users... no need for i18n (sorry TOR!)
//$wgExtensionMessagesFiles['VideoUploadPrototype'] = $dir . 'Special_VideoUploadPrototype.i18n.php';

$wgSpecialPages['VideoUploadPrototype'] = 'VideoUploadPrototype';
//Special:VideoUploadHelper -> workaround - see http://www.longtailvideo.com/support/forums/bits-on-the-run/system-api/18401/handling-upload-response-in-js
$wgSpecialPages['VideoUploadHelper'] = 'SpecialVideoUploadHelper';

//Ajax dispatcher
$wgAjaxExportList[] = 'VideoUpload';
function VideoUpload() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('VideoUploadAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = VideoUploadAjax::$method();

		if (is_array($data)) {
			// send array as JSON
			$json = json_encode($data);
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
