<?php
/*
 * @author Bartek Łapiński 
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}


// for now it's more a copy of VideoEmbedTool files
$wgExtensionCredits['other'][] = array(
        'name' => 'Video Embed Tool',
        'author' => 'Bartek Łapiński, Inez Korczyński',
	'version' => '0.51',
);

$dir = dirname(__FILE__).'/';

define( 'VIDEO_PREVIEW', 350 );

$wgExtraNamespaces[400] = "Video";
$wgExtraNamespaces[401] = "Video_talk";
require_once( "$IP/extensions/wikia/WikiaVideo/WikiaVideo.php" );

#--- register special page (MW 1.1x way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

//extAddSpecialPage( dirname(__FILE__) . '/QuickVideoAdd_body.php', 'QuickVideoAdd', 'QuickVideoAddForm' );

$wgExtensionFunctions[] = "VETSetupHook";
$wgExtensionMessagesFiles['VideoEmbedTool'] = $dir.'/VideoEmbedTool.i18n.php';
$wgHooks['EditPage::showEditForm:initial2'][] = 'VETSetup';

function VETSetupHook() {
	global $wgParser;		
	$wgParser->setHook( "video", "VETParserHook" );
	return true;
}

function VETArticleSave( $article, $user, $text, $summary) {
	if (NS_VIDEO == $article->mTitle->getNamespace()) {
		$text = $article->dataline . $text;
	}
	return true;
}

function VETParserHook( $input, $argv, $parser ) {
	// todo get video name, get embed code, display that code
	$name = '';
	$width = 300;
	$width_max = 600;
	$height_max = 600;
	$align = 'left';
	$caption = '';
	$thumb = 'false';

	if (!empty($argv['name'])) {
                $name = $argv['name'];
        }
	if (!empty($argv['align'])) {
                $align = $argv['align'];
        }
	if (!empty($argv['caption'])) {
                $caption = $argv['caption'];
        }
	if (!empty($argv['thumb'])) {
                $thumb = $argv['thumb'];
        }

	$title = Title::makeTitle( NS_VIDEO, $name );

	$video = new VideoPage( $title );
	$video->load();

        if (!empty($argv['width']) && settype($argv['width'], 'integer') && ($width_max >= $argv['width']))
        {
                $width = $argv['width'];
        }

	$output = $video->generateWindow( $align, $width, $caption, $thumb );
	return $output;
}

function VETSetup($editform) {
	global $wgOut, $wgStylePath, $wgExtensionsPath, $wgStyleVersion, $wgHooks, $wgUser;
	if(get_class($wgUser->getSkin()) == 'SkinMonaco') {
		wfLoadExtensionMessages('VideoEmbedTool');
		$wgHooks['ExtendJSGlobalVars'][] = 'VETSetupVars';
		$wgOut->addScript('<script type="text/javascript" src="'.$wgStylePath.'/common/yui_2.5.2/slider/slider-min.js?'.$wgStyleVersion.'"></script>');
		$wgOut->addScript('<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/VideoEmbedTool/js/VET.js?'.$wgStyleVersion.'"></script>');
		$wgOut->addScript('<link rel="stylesheet" type="text/css" href="'.$wgExtensionsPath.'/wikia/VideoEmbedTool/css/VET.css?'.$wgStyleVersion.'" />');
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

function VETSetupVars($vars) {
	global $wgFileBlacklist, $wgCheckFileExtensions, $wgStrictFileExtensions, $wgFileExtensions;

	$vars['vet_back'] = wfMsg('vet-back');
	$vars['vet_imagebutton'] = wfMsg('vet-imagebutton') ;
	$vars['vet_close'] = wfMsg('vet-close');
	$vars['vet_warn1'] = wfMsg('vet-warn1');
	$vars['vet_warn2'] = wfMsg('vet-warn2');
	$vars['vet_warn3'] = wfMsg('vet-warn3');
	$vars['vet_bad_extension'] = wfMsg('vet-bad-extension');
	$vars['filetype_missing'] = wfMsg('filetype-missing');
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

	// macbre: for FCK
	$vars['vet_enabled'] = true;

	return true;
}

$wgAjaxExportList[] = 'VET';

function VET() {
	global $wgRequest, $wgGroupPermissions, $wgAllowCopyUploads;

	// todo change
	wfLoadExtensionMessages('VideoEmbedTool');

	// Overwrite configuration settings needed by image import functionality
	$wgAllowCopyUploads = true;
	$wgGroupPermissions['user']['upload_by_url']   = true;
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
