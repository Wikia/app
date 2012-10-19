<?php
/*
 * @author Bartek Łapiński
 */


if(!defined('MEDIAWIKI')) {
	exit(1);
}


// for now it's more a copy of VideoEmbedTool files
// TODO: L10n-able description
$wgExtensionCredits['other'][] = array(
        'name' => 'Video Embed Tool',
        'author' => 'Bartek Łapiński, Inez Korczyński',
	'version' => '0.99',
);
$app = F::app();
$dir = dirname(__FILE__).'/';

$app->registerController('VideoEmbedToolController',	$dir . '/VideoEmbedToolController.class.php' );

define( 'VIDEO_PREVIEW', 350 );

switch( $wgLanguageCode ) {
/*
	case "pl" :
	$wgExtraNamespaces[400] = 'Wideo';
	$wgExtraNamespaces[401] = 'Dyskusja_wideo';

	$wgNamespaceAliases['Video'] = 400;
	$wgNamespaceAliases['Video_talk'] = 401;
	break;
*/
	case "en" :
	default :
		//$wgExtraNamespaces[6] = "Video";
		//$wgExtraNamespaces[7] = "Video_talk";
		$wgNamespaceAliases["Video"] = 6;
		$wgNamespaceAliases["Video_talk"] = 7;
		break;
	case "ru":
		//$wgExtraNamespaces[6] = "Видео";
		//$wgExtraNamespaces[7] = "Обсуждение_видео";
		$wgNamespaceAliases["Video"] = 6;
		$wgNamespaceAliases["Video_talk"] = 7;
		break;
	case "no":
	case "nn":
		//$wgExtraNamespaces[6] = "Video";
		//$wgExtraNamespaces[7] = "Videodiskusjon";
		$wgNamespaceAliases["Video"] = 6;
		$wgNamespaceAliases["Video_talk"] = 7;
		break;
}

#--- register special page (MW 1.1x way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

$wgExtensionMessagesFiles['WikiaVideoAdd'] = dirname(__FILE__) . '/WikiaVideoAdd.i18n.php';
extAddSpecialPage( dirname(__FILE__) . '/WikiaVideoAdd_body.php', 'WikiaVideoAdd', 'WikiaVideoAddForm' );

$wgExtensionMessagesFiles['VideoEmbedTool'] = $dir.'/VideoEmbedTool.i18n.php';
$wgHooks['EditPage::showEditForm:initial2'][] = 'VETSetup';

/**
 * @param $article
 * @param $user
 * @param $text
 * @param $summary
 * @return bool
 */
function VETArticleSave( $article, $user, &$text, $summary) {
	if (NS_VIDEO == $article->mTitle->getNamespace()) {
		$text = $article->dataline . $text;
	}
	return true;
}

/**
 * @param EditPage $editform
 * @return bool
 */
function VETSetup($editform) {
	global $wgOut, $wgExtensionsPath, $wgHooks;
	if( get_class(RequestContext::getMain()->getSkin()) === 'SkinOasis' ) {
		$wgHooks['MakeGlobalVariablesScript'][] = 'VETSetupVars';
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/VideoEmbedTool/js/VET.js"></script>');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/WikiaStyleGuide/js/Dropdown.js"></script>');
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/VideoEmbedTool/css/VET.scss'));
		$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaStyleGuide/css/Dropdown.scss'));
	}
	return true;
}

/**
 * @param array $vars
 * @return bool
 */
function VETSetupVars(Array &$vars) {
	global $wgFileBlacklist, $wgCheckFileExtensions, $wgStrictFileExtensions, $wgFileExtensions;

	$vars['vet_back'] = wfMsg('vet-back');
	$vars['vet_imagebutton'] = wfMsg('vet-imagebutton') ;
	$vars['vet_close'] = wfMsg('vet-close');
	$vars['vet_warn1'] = wfMsg('vet-warn1');
	$vars['vet_warn2'] = wfMsg('vet-warn2');
	$vars['vet_warn3'] = wfMsg('vet-warn3');
	$vars['vet_insert_error'] = wfMsg('vet-insert-error');
	$vars['vet_bad_extension'] = wfMsg('vet-bad-extension');
	$vars['file_extensions'] = $wgFileExtensions;
	$vars['file_blacklist'] = $wgFileBlacklist;
	$vars['check_file_extensions'] = $wgCheckFileExtensions;
	$vars['strict_file_extensions'] = $wgStrictFileExtensions;
	$vars['vet_show_message'] = wfMsg('vet-show-message');
	$vars['vet_hide_message'] = wfMsg('vet-hide-message');
	$vars['vet_show_license_message'] = wfMsg('vet-show-license-msg');
	$vars['vet_hide_license_message'] = wfMsg('vet-hide-license-msg');
	$vars['vet_max_thumb'] = wfMsg('vet-max-thumb');
	$vars['vet_title'] = wfMsg('vet-title');
	$vars['vet_no_preview'] = wfMsg( 'vet-no-preview' );

	// macbre: for FCK
	$vars['vet_enabled'] = true;

	return true;
}

$wgAjaxExportList[] = 'VET';

function VET() {
	global $wgRequest;

	$dir = dirname(__FILE__).'/';
	require_once($dir.'VideoEmbedTool_body.php');

	$method = $wgRequest->getVal('method');
	$vet = new VideoEmbedTool();

	$html = $vet->$method();
	$domain = $wgRequest->getVal('domain', null);
	if(!empty($domain)) {
		$html .= '<script type="text/javascript">document.domain = "' . $domain  . '"</script>';
	}
	return new AjaxResponse($html);
}
