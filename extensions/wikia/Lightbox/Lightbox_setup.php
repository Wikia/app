<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'Lightbox',
	'version' => '1.0',
	'description' => 'Add lightbox preview for images within article',
	'author' => array('Maciej Brencz', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]', 'Liz Lee', 'Hyun Lim'),
);

// register extension class
$dir = dirname(__FILE__);
$wgAutoloadClasses['Lightbox'] = "$dir/Lightbox.class.php";

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'Lightbox::addJSVariable';

// i18n
$wgExtensionMessagesFiles['Lightbox'] = $dir.'/Lightbox.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'LightboxAjax';
function LightboxAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('Lightbox', $method)) {
		wfProfileIn(__METHOD__);

		$data = Lightbox::$method();

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