<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'MagCloud Collection',
	'description' => 'An intuitive way for users to collect articles together into a PDF which can then be delivered to MagCloud for printing',
	'author' => array('Maciej Brencz', 'Adrian Wieczorek', 'Przemek Piotrowski (Nef)')
);

$dir = dirname(__FILE__) . '/';

// register extension classes
$wgAutoloadClasses['MagCloud'] = $dir.'MagCloud.class.php';
$wgAutoloadClasses['MagCloudAjax'] = $dir.'MagCloudAjax.class.php';
$wgAutoloadClasses['MagCloudCollection'] = $dir.'MagCloudCollection.class.php';
$wgAutoloadClasses['MagCloudApi'] = $dir.'MagCloudApi.class.php';

// special page
$wgAutoloadClasses['WikiaCollection'] = $dir.'SpecialWikiaCollection.class.php';
$wgSpecialPages['WikiaCollection'] = 'WikiaCollection';

// i18n
$wgExtensionMessagesFiles['MagCloud'] = $dir.'MagCloud.i18n.php';

// hooks
$wgHooks['BeforePageDisplay'][] = 'MagCloud::beforePageDisplay';
$wgHooks['GetHTMLAfterBody'][] = 'MagCloud::injectToolbar';
$wgHooks['MakeGlobalVariablesScript'][] = 'MagCloud::makeGlobalVariablesScript';

// MagCloud upload paths
if (empty($wgMagCloudUploadDirectory)) {
	$wgMagCloudUploadDirectory = "/images/m/magcloud";
}
if (empty($wgMagCloudUploadPath)) {
	$wgMagCloudUploadPath = "http://images.wikia.com/m/magcloud";
}

// MagCloud API key
$wgMagCloudPublicApiKey  = 'f0515620-ce8d-41f1-9354-d6907d4bf201';

// Ajax dispatcher
$wgAjaxExportList[] = 'MagCloudAjax';
function MagCloudAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('MagCloudAjax', $method)) {
		wfLoadExtensionMessages('MagCloud');

		$data = MagCloudAjax::$method();

		// JSON encode array
		if (is_array($data)) {
			$data['host'] = php_uname('n');
			$json = Wikia::json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		}
		// return HTML
		else {
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}

		return $response;
	}
}
