<?php

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'WikiBuilder',
	'descriptionmsg' => 'wikibuilder-desc',
	'author' => array('Hyun Lim', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

$dir = dirname(__FILE__).'/';

// autoloads
$wgAutoloadClasses['WikiBuilderController'] = $dir . 'WikiBuilderController.class.php';
$wgAutoloadClasses['SpecialWikiBuilder'] = $dir . 'SpecialWikiBuilder.class.php';

// special pages
$wgSpecialPages['WikiBuilder'] = 'SpecialWikiBuilder';

// i18n
$wgExtensionMessagesFiles['WikiBuilder'] = $dir . 'WikiBuilder.i18n.php';

// TODO: Permissions
$wgAvailableRights[] = 'wikibuilder';
$wgGroupPermissions['*']['wikibuilder'] = false;
$wgGroupPermissions['sysop']['wikibuilder'] = true;
$wgGroupPermissions['bureaucrat']['wikibuilder'] = true;
$wgGroupPermissions['staff']['wikibuilder'] = true;

// Ajax dispatcher
$wgAjaxExportList[] = 'WikiBuilderAjax';
function WikiBuilderAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('SpecialWikiBuilder', $method)) {
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('WikiBuilder');
		$data = SpecialWikiBuilder::$method();

		if (is_array($data)) {
			// send array as JSON
			$json = Wikia::json_encode($data);
			$response = new AjaxResponse($json);
			$response->setContentType('application/json; charset=utf-8');
		} else {
			// send text as text/html
			$response = new AjaxResponse($data);
			$response->setContentType('text/html; charset=utf-8');
		}

		wfProfileOut(__METHOD__);
		return $response;
	}
}