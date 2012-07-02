<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Image Lightbox',
	'version' => '1.21',
	'description' => 'Add lightbox preview for images within article',
	'author' => array('Maciej Brencz', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
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
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('ImageLightbox', $method)) {
		wfProfileIn(__METHOD__);

		$data = ImageLightbox::$method();

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