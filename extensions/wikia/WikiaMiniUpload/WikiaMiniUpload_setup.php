<?php
/*
 * @author Inez Korczyński
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'WikiaMiniUpload',
        'author' => 'Inez Korczyński',
);

$dir = dirname(__FILE__).'/';

$wgExtensionMessagesFiles['WikiaMiniUpload'] = $dir.'/WikiaMiniUpload.i18n.php';
$wgHooks['EditPage::showEditForm:initial2'][] = 'WMUSetup';

function WMUSetup($editform) {
	global $wgOut, $wgStylePath, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgUser;
	if(get_class($wgUser->getSkin()) == 'SkinMonaco') {
		wfLoadExtensionMessages('WikiaMiniUpload');
		$wgHooks['ExtendJSGlobalVars'][] = 'WMUSetupVars';
		$wgOut->addScript('<script type="text/javascript" src="'.$wgStylePath.'/common/yui_2.5.2/slider/slider-min.js?'.$wgStyleVersion.'"></script>');
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
		$wgOut->addHtml('<div style="float: left; margin-top: 20px;' . $marg .'"><a href="#" id="wmuLink">' . $sep . wfMsg ('wmu-imagelink') . '</a></div>');
	}
	return true;
}

function WMUSetupVars($vars) {
	$vars['wmu_back'] = wfMsg('wmu-back');
	$vars['wmu_imagebutton'] = wfMsg('wmu-imagebutton') ;
	$vars['wmu_close'] = wfMsg('wmu-close');
	$vars['wmu_warn1'] = wfMsg('wmu-warn1');
	$vars['wmu_warn2'] = wfMsg('wmu-warn2');
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
	return new AjaxResponse($wmu->$method());
}
