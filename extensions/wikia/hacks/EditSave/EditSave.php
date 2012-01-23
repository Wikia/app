<?
$wgHooks['GetHTMLAfterBody'][] = 'editPageJS';

function editPageJS() {
	global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType, $wgRequest;
	$action = $wgRequest->getVal('action', null);
	
	if ($action == 'edit') {
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/hacks/EditSave/js/EditSave.js?{$wgStyleVersion}\"></script>");
	}

	return true;
}
