<?php
/*
 * @author Inez Korczyński
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'WikiaMiniUpload (Add Images)',
        'author' => array(
			'Inez Korczyński', 
			'Bartek Łapiński'
		),
		'descriptionmsg' => 'wmu-desc',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaMiniUpload'
);

$dir = dirname(__FILE__).'/';

$wgExtensionMessagesFiles['WikiaMiniUpload'] = $dir.'/WikiaMiniUpload.i18n.php';
$wgHooks['EditPage::showEditForm:initial2'][] = 'WMUSetup';

function WMUSetup($editform) {
	global $wgHooks;

	if( get_class(RequestContext::getMain()->getSkin()) === 'SkinOasis' ) {
		$wgHooks['MakeGlobalVariablesScript'][] = 'WMUSetupVars';
		if (isset ($editform->ImageSeparator)) {
		} else {
			$editform->ImageSeparator = ' - ' ;
		}
	}
	return true;
}

function WMUSetupVars(Array &$vars) {
	global $wgFileBlacklist, $wgCheckFileExtensions, $wgStrictFileExtensions, $wgFileExtensions;

	$vars['wgEnableWikiaMiniUploadExt'] = true;

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
	$vars['wmu_show_license_message'] = wfMsg('wmu-show-license-msg');
	$vars['wmu_hide_license_message'] = wfMsg('wmu-hide-license-msg');
	$vars['wmu_max_thumb'] = wfMsg('wmu-max-thumb');
	$vars['badfilename'] = wfMsg( 'badfilename' );

	return true;
}

$wgAjaxExportList[] = 'WMU';

function WMU() {
	global $wgRequest, $wgAllowCopyUploads;

	// Overwrite configuration settings needed by image import functionality
	$wgAllowCopyUploads = true;

	$method = $wgRequest->getVal('method');
	$wmu = new WikiaMiniUpload();

	if ( method_exists( $wmu, $method ) ) {
		$html = $wmu->$method();
		$ar = new AjaxResponse( $html );
		$ar->setContentType( 'text/html; charset=utf-8' );
	} else {
		$errorMessage = 'WMU::' . $method . ' does not exist';

		\Wikia\Logger\WikiaLogger::instance()->error( $errorMessage );

		$payload = json_encode( [ 'message' => $errorMessage ] );
		$ar = new AjaxResponse( $payload );
		$ar->setResponseCode( '501 Not implemented' );
		$ar->setContentType( 'application/json; charset=utf-8' );
	}
	return $ar;
}

$wgAutoloadClasses['WikiaMiniUpload'] = __DIR__ . '/WikiaMiniUpload_body.php';

$wgResourceModules['ext.wikia.WMU'] = array(
	'scripts' => 'js/WMU.js',
	'styles' => 'css/WMU.css',
	'dependencies' => array( 'wikia.yui', 'jquery.aim' ),
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/WikiaMiniUpload'
);