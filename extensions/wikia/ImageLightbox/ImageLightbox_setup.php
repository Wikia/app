<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Image Lightbox',
	'version' => '1.12',
	'description' => 'Add lightbox preview for gallery images',
	'author' => 'Maciej Brencz',
);

// register extension class
$dir = dirname(__FILE__);
$wgAutoloadClasses['ImageLightbox'] = "$dir/ImageLightbox.class.php";

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'ImageLightbox::addJSVariable';

// i18n
$wgExtensionMessagesFiles['ImageLightbox'] = $dir.'/ImageLightbox.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'ImageLightboxAjax';
function ImageLightboxAjax() {
	$data = ImageLightbox::ajax();
	$json = Wikia::json_encode($data);

	$response = new AjaxResponse($json);
	$response->setContentType('application/json; charset=utf-8');

	return $response;
}
