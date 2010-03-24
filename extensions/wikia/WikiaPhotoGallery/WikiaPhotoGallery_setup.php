<?php

/**
 * PhotoGallery
 *
 * A PhotoGallery extension for MediaWiki
 * Provides an interface for managing galleries in articles (edit and view modes)
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-03-08
 * @copyright Copyright (C) 2010 Maciej Brencz, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WikiaPhotoGallery/WikiaPhotoGallery_setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Photo Gallery',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Gallery',
	'author' => array('[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]', 'Maciej Brencz')
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['WikiaPhotoGallery'] = "$dir/WikiaPhotoGallery.class.php";
$wgAutoloadClasses['WikiaPhotoGalleryAjax'] = "$dir/WikiaPhotoGalleryAjax.class.php";
$wgAutoloadClasses['WikiaPhotoGalleryHelper'] = "$dir/WikiaPhotoGalleryHelper.class.php";
$wgAutoloadClasses['WikiaPhotoGalleryUpload'] = "$dir/WikiaPhotoGalleryUpload.class.php";

$wgAutoloadClasses['FakeLocalFile'] = "$dir/FakeLocalFile.class.php";

// special page (used during development to test image search)
include("$dir/WikiaPhotoGallery.special.php");

// hooks
$wgHooks['renderImageGallerySetup'][] = 'WikiaPhotoGalleryHelper::setup';
$wgHooks['BeforeParserrenderImageGallery'][] = 'WikiaPhotoGalleryHelper::beforeRenderImageGallery';
$wgHooks['RTEUseDefaultPlaceholder'][] = 'WikiaPhotoGalleryHelper::useDefaultRTEPlaceholder';
$wgHooks['EditPage::showEditForm:initial2'][] = 'WikiaPhotoGalleryHelper::setupEditPage';
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'WikiaPhotoGalleryHelper::fetchTemplateAndTitle';

// i18n
$wgExtensionMessagesFiles['WikiaPhotoGallery'] = $dir.'/i18n/WikiaPhotoGallery.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiaPhotoGalleryAjax';
function WikiaPhotoGalleryAjax() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('WikiaPhotoGalleryAjax', $method)) {
		wfProfileIn(__METHOD__);
		wfLoadExtensionMessages('WikiaPhotoGallery');

		$data = WikiaPhotoGalleryAjax::$method();

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
