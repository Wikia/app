<?php
/*
 * @author Inez Korczyński
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'WikiaMiniUpload (Add Images)',
        'author' => 'Inez Korczyński, Bartek Łapiński',
);

$dir = dirname(__FILE__).'/';

$wgExtensionMessagesFiles['WikiaMiniUpload'] = $dir.'/WikiaMiniUpload.i18n.php';
$wgHooks['EditPage::showEditForm:initial2'][] = 'WMUSetup';

function WMUSetup($editform) {
	global $wgOut, $wgStylePath, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgUser;

	if( in_array(get_class($wgUser->getSkin()), array('SkinMonaco', 'SkinOasis')) ) {
		wfLoadExtensionMessages('WikiaMiniUpload');
		$wgHooks['MakeGlobalVariablesScript'][] = 'WMUSetupVars';
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/WikiaMiniUpload/js/WMU.js?'.$wgStyleVersion.'"></script>');
		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/WikiaMiniUpload/css/WMU.css?'.$wgStyleVersion.'" />');
		if (isset ($editform->ImageSeparator)) {
			$sep = $editform->ImageSeparator ;
			$marg = 'margin-left:5px;' ;
		} else {
			$sep = '' ;
			$marg =  'clear: both;' ;
			$editform->ImageSeparator = ' - ' ;
		}
	}
	return true;
}

function WMUSetupVars($vars) {
	global $wgFileBlacklist, $wgCheckFileExtensions, $wgStrictFileExtensions, $wgFileExtensions;

	$vars['wmu_back'] = wfMsg('wmu-back');
	$vars['wmu_imagebutton'] = wfMsg('wmu-imagebutton') ;
	$vars['wmu_close'] = wfMsg('wmu-close');
	$vars['wmu_no_preview'] = wfMsg('wmu-no-preview');
	$vars['wmu_warn1'] = wfMsg('wmu-warn1');
	$vars['wmu_warn2'] = wfMsg('wmu-warn2');
	$vars['wmu_warn3'] = wfMsg('wmu-warn3');
	$vars['wmu_bad_extension'] = wfMsg('wmu-bad-extension');
	$vars['filetype_missing'] = wfMsg('filetype-missing');
	$vars['file_extensions'] = $wgFileExtensions;
	$vars['file_blacklist'] = $wgFileBlacklist;
	$vars['check_file_extensions'] = $wgCheckFileExtensions;
	$vars['strict_file_extensions'] = $wgStrictFileExtensions;
	$vars['wmu_show_message'] = wfMsg('wmu-show-message');
	$vars['wmu_hide_message'] = wfMsg('wmu-hide-message');
	$vars['wmu_show_license_message'] = wfMsg('wmu-show-license-msg');
	$vars['wmu_hide_license_message'] = wfMsg('wmu-hide-license-msg');
	$vars['wmu_max_thumb'] = wfMsg('wmu-max-thumb');
	$vars['badfilename'] = wfMsg( 'badfilename' );

	return true;
}

$wgAjaxExportList[] = 'WMU';

function WMU() {
	global $wgRequest, $wgGroupPermissions, $wgAllowCopyUploads;

	wfLoadExtensionMessages('WikiaMiniUpload');

	// Overwrite configuration settings needed by image import functionality
	$wgAllowCopyUploads = true;
	$wgGroupPermissions['user']['upload_by_url']   = true;
	$dir = dirname(__FILE__).'/';
	require_once($dir.'WikiaMiniUpload_body.php');

	$method = $wgRequest->getVal('method');
	$wmu = new WikiaMiniUpload();

	$html = $wmu->$method();
	$domain = $wgRequest->getVal('domain', null);
	if(!empty($domain)) {
		$html .= '<script type="text/javascript">document.domain = "' . $domain  . '"</script>';
	}
	$ar = new AjaxResponse($html);
	$ar->setContentType('text/html; charset=utf-8');
	return $ar;
}
