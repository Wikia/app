<?
$wgHooks['GetHTMLAfterBody'][] = 'editPageJS';

function editPageJS() {
	global $wgOut, $wgExtensionsPath, $wgJsMimeType, $wgRequest;
	$action = $wgRequest->getVal('action', null);

	if ($action == 'edit') {
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/hacks/EditSave/js/EditSave.js\"></script>");
	}

	return true;
}
