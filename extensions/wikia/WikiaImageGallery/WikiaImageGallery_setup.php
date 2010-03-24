<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'E-Z Image Gallery',
	'url' => 'http://www.wikia.com/wiki/c:help:Help:Gallery',
	'author' => array('[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]', 'Maciej Brencz')
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['WikiaImageGallery'] = "$dir/WikiaImageGallery.class.php";
$wgAutoloadClasses['WikiaImageGalleryAjax'] = "$dir/WikiaImageGalleryAjax.class.php";
$wgAutoloadClasses['WikiaImageGalleryHelper'] = "$dir/WikiaImageGalleryHelper.class.php";
include("$dir/WikiaImageGallery.special.php");

// hooks
$wgHooks['renderImageGallerySetup'][] = 'WikiaImageGalleryHelper::setup';
$wgHooks['BeforeParserrenderImageGallery'][] = 'WikiaImageGalleryHelper::beforeRenderImageGallery';
$wgHooks['RTEUseDefaultPlaceholder'][] = 'WikiaImageGalleryHelper::useDefaultRTEPlaceholder';
$wgHooks['EditPage::showEditForm:initial2'][] = 'WikiaImageGalleryHelper::setupEditPage';

// i18n
$wgExtensionMessagesFiles['WikiaImageGallery'] = $dir.'/i18n/WikiaImageGallery.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiaImageGalleryAjax';
function WikiaImageGalleryAjax() {
	global $wgUser, $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('WikiaImageGalleryAjax', $method)) {
		wfProfileIn(__METHOD__);
		wfLoadExtensionMessages('WikiaImageGallery');

		$data = WikiaImageGalleryAjax::$method();
		$json = Wikia::json_encode($data);

		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');
		wfProfileOut(__METHOD__);
		return $response;
	}
}
