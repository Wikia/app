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
$dir = dirname(__FILE__).'/';

$wgAutoloadClasses['VideoEmbedTool'] = $dir . 'VideoEmbedTool_body.php';
$wgAutoloadClasses['VideoEmbedToolSearchService'] = $dir . 'VideoEmbedToolSearchService.class.php';
$wgAutoloadClasses['VideoEmbedToolController'] = $dir . '/VideoEmbedToolController.class.php';

define( 'VIDEO_PREVIEW', 350 );

$wgNamespaceAliases["Video"] = 6;
$wgNamespaceAliases["Video_talk"] = 7;

#--- register special page (MW 1.1x way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

$wgExtensionMessagesFiles['WikiaVideoAdd'] = dirname(__FILE__) . '/WikiaVideoAdd.i18n.php';
$wgExtensionMessagesFiles['WikiaVideoAddAliases'] = dirname(__FILE__) . '/WikiaVideoAdd.alias.php';
extAddSpecialPage( dirname(__FILE__) . '/WikiaVideoAdd_body.php', 'WikiaVideoAdd', 'WikiaVideoAddForm' );

$wgExtensionMessagesFiles['VideoEmbedTool'] = $dir.'/VideoEmbedTool.i18n.php';
$wgHooks['EditPage::showEditForm:initial2'][] = 'VETSetup';

JSMessages::registerPackage('VideoEmbedTool', array(
	'vet-warn2',
	'vet-warn3',
	'vet-insert-error',
	'vet-imagebutton',
));
JSMessages::enqueuePackage('VideoEmbedTool', JSMessages::EXTERNAL);


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
	}
	return true;
}

/**
 * @param array $vars
 * @return bool
 */
function VETSetupVars(Array &$vars) {
	global $wgFileBlacklist, $wgCheckFileExtensions, $wgStrictFileExtensions, $wgFileExtensions, $wgEnableVideoToolExt;

	$vars['wgEnableVideoToolExt'] = $wgEnableVideoToolExt;
	$vars['file_extensions'] = $wgFileExtensions;
	$vars['file_blacklist'] = $wgFileBlacklist;
	$vars['check_file_extensions'] = $wgCheckFileExtensions;
	$vars['strict_file_extensions'] = $wgStrictFileExtensions;

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
