<?php

/**
 * PhotoGallery
 *
 * A PhotoGallery extension for MediaWiki
 * Provides an interface for managing galleries in articles (edit and view modes)
 *
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2010-03-08
 * @copyright Copyright (C) 2010 Maciej Brencz, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/WikiaPhotoGallery/WikiaPhotoGallery_setup.php");
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'Photo Gallery',
	'version' => '4.0',
	'url' => 'http://community.wikia.com/wiki/Help:Gallery',
	'author' => array( '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]', 'Maciej Brencz' ),
	'descriptionmsg' => 'wikiaphotogallery-desc',
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['WikiaPhotoGallery'] = "$dir/WikiaPhotoGallery.class.php";
$wgAutoloadClasses['WikiaPhotoGalleryAjax'] = "$dir/WikiaPhotoGalleryAjax.class.php";
$wgAutoloadClasses['WikiaPhotoGalleryHelper'] = "$dir/WikiaPhotoGalleryHelper.class.php";
$wgAutoloadClasses['WikiaPhotoGalleryUpload'] = "$dir/WikiaPhotoGalleryUpload.class.php";

// hooks
$wgHooks['renderImageGallerySetup'][] = 'WikiaPhotoGalleryHelper::setup';
$wgHooks['BeforeParserrenderImageGallery'][] = 'WikiaPhotoGalleryHelper::beforeRenderImageGallery';
$wgHooks['RTEUseDefaultPlaceholder'][] = 'WikiaPhotoGalleryHelper::useDefaultRTEPlaceholder';
$wgHooks['EditPage::showEditForm:initial2'][] = 'WikiaPhotoGalleryHelper::setupEditPage';
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'WikiaPhotoGalleryHelper::fetchTemplateAndTitle';
/* temp transition code until grid is fully rolled out, remove and integrate after transition */
$wgHooks['MakeGlobalVariablesScript'][] = 'WikiaPhotoGalleryHelper::makeGlobalVariablesScriptForWikiaGrid';
$wgHooks['EditPage::importFormData'][] = 'WikiaPhotoGalleryHelper::onImportFormData';
/* end temp transistion code */
// This is temporary for the prototype stage of media gallery
// TODO: Remove this hook once media gallery is ready to be fully deployed
$wgHooks[ 'PageRenderingHash' ][] = 'WikiaPhotoGalleryHelper::addMediaGalleryCacheKey';

// i18n
$wgExtensionMessagesFiles['WikiaPhotoGallery'] = $dir.'/WikiaPhotoGallery.i18n.php';

// ResourceLoader module
$wgResourceModules['ext.WikiaPhotoGallery'] = [
	'scripts' => 'js/WikiaPhotoGallery.js',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/WikiaPhotoGallery',
];

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiaPhotoGalleryAjax';
function WikiaPhotoGalleryAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('WikiaPhotoGalleryAjax', $method)) {
		wfProfileIn(__METHOD__);

		$data = WikiaPhotoGalleryAjax::$method();

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
