<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980 
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'WikiaVideo_initParserHook';
} else {
	$wgExtensionFunctions[] = 'WikiaVideo_initParserHook';
}

$wgExtensionFunctions[] = 'WikiaVideo_init';

$wgHooks['ParserBeforeStrip'][] = 'WikiaVideoParserBeforeStrip';
$wgHooks['SpecialNewImages::beforeQuery'][] = 'WikiaVideoNewImagesBeforeQuery';
$wgHooks['SpecialWhatlinkshere::beforeImageQuery'][] = 'WikiaVideoWhatlinkshereBeforeQuery';
$wgWikiaVideoGalleryId = 0;
$wgWikiaVETLoaded = false;

function WikiaVideoWhatlinkshereBeforeQuery( $hideimages, $pageconds, $targetconds, $imageconds ) {	
	if( NS_VIDEO == $pageconds['pl_namespace'] ) {
		$hideimages = false;		
		$imageconds['il_to'] = ':' . $imageconds['il_to'];
	}
	return true;
}

function WikiaVideoNewImagesBeforeQuery( $where ) {
        $where[] = 'img_media_type != \'VIDEO\'';
        $where[] = 'img_major_mime != \'video\'';
        $where[] = 'img_media_type != \'swf\'';
        return true;
}

function WikiaVideoParserBeforeStrip($parser, $text, $strip_state) {
	global $wgExtraNamespaces, $wgWysiwygParserEnabled, $wgWikiaVideoGalleryId;

	$wgWikiaVideoGalleryId = 0;

	// macbre: don't touch anything when parsing for FCK
	if (!empty($wgWysiwygParserEnabled)) {
		return true;
	}

	$pattern = "/<videogallery/";                   
	$text = preg_replace_callback($pattern, 'WikiaVideoPreRenderVideoGallery', $text);
	return true;
}

function WikiaVideoPreRenderVideoGallery( $matches ) {
	global $wgWikiaVideoGalleryId;	
	$result = $matches[0] . ' id="' . $wgWikiaVideoGalleryId . '"';
	$wgWikiaVideoGalleryId++;
	return $result;
}

function WikiaVideo_init() {
	global $wgExtraNamespaces, $wgNamespaceAliases, $wgAutoloadClasses, $wgLanguageCode;

	switch ( $wgLanguageCode ) {
		case 'de':
			$wgExtraNamespaces[NS_VIDEO] = 'Video';
			$wgExtraNamespaces[NS_VIDEO + 1] = 'Video_Diskussion';
			$wgNamespaceAliases['Video_talk'] = NS_VIDEO + 1;
			break;
		case 'pl':
			$wgExtraNamespaces[NS_VIDEO] = 'Video';
			$wgExtraNamespaces[NS_VIDEO + 1] = 'Dyskusja_Video';
			$wgNamespaceAliases['Video_talk'] = NS_VIDEO + 1;
			break;
		default:
			$wgExtraNamespaces[NS_VIDEO] = 'Video';
			$wgExtraNamespaces[NS_VIDEO + 1] = 'Video_talk';
	}
	$wgAutoloadClasses['VideoPage'] = dirname(__FILE__). '/VideoPage.php';
}

function WikiaVideo_initParserHook() {
	global $wgParser;
	$wgParser->setHook('videogallery', 'WikiaVideo_renderVideoGallery');
	return true;
}

function WikiaVideo_renderVideoGallery($input, $args, $parser) {
	$out = '';
	$videos = array();

	global $wgHooks;
	wfLoadExtensionMessages('VideoEmbedTool');
	$wgHooks['MakeGlobalVariablesScript'][] = 'VETSetupVars';
	
	$lines = explode("\n", $input);
	foreach($lines as $line) {
		$matches = array();
		preg_match( "/^([^|]+)(\\|(.*))?$/", $line, $matches );

		if(count($matches) == 0) {
			continue;
		}

		if(strpos($matches[0], '%') !== false) {
			$matches[1] = urldecode($matches[1]);
		}

		$tp = Title::newFromText($matches[1]);
		$nt =& $tp;

		if(is_null($nt)) {
			continue;
		}

		if(isset($matches[3])) {
			$html = $parser->recursiveTagParse(trim($matches[3]));
		} else {
			$html = '';
		}

		$videos[] = array($tp, $html);
	}

	if(count($videos) > 0) {
		// todo check if VET enabled
		global $wgUser, $wgWikiaVETLoaded;
		
		// for first gallery, load VET js
		$out .= '<table class="gallery" cellspacing="0" cellpadding="0"><tr>';
		$out .= '<script type="text/javascript">';
		$out .= 'var vet_back = \'' . wfMsg('vet-back') . '\';';
		$out .= 'var vet_imagebutton = \'' . wfMsg('vet-imagebutton') . '\';';
		$out .= 'var vet_close = \'' . wfMsg('vet-close') . '\';';
		$out .= 'var vet_warn1 = \'' . wfMsg('vet-warn1') . '\';';
		$out .= 'var vet_warn2 = \'' . wfMsg('vet-warn2') . '\';';
		$out .= 'var vet_warn3 = \'' . wfMsg('vet-warn3') . '\';';

		$out .= 'var vet_bad_extension = \'' . wfMsg('vet-bad-extension') . '\';';
		$out .= 'var vet_show_message = \'' . wfMsg('vet-show-message') . '\';';
		$out .= 'var vet_hide_message = \'' . wfMsg('vet-hide-message') . '\';';
		$out .= 'var vet_title = \'' . wfMsg('vet-title') . '\';';
		$out .= 'var vet_max_thumb = \'' . wfMsg('vet-max-thumb') . '\';';

		$out .= '</script>';

		for($i = 0; $i < count($videos); $i++) {
			$video = new VideoPage($videos[$i][0]);
			$video->load();
			$out .= '<td><div class="gallerybox" style="width: 335px;"><div class="thumb" style="padding: 13px 0; width: 330px;"><div style="margin-left: auto; margin-right: auto; width: 300px;">'.$video->getEmbedCode().'</div></div><div class="gallerytext">'.(!empty($videos[$i][1]) ? $videos[$i][1] : '').'</div></div></td>';

			if($i%2 == 1) {
				$out .= '</tr><tr>';
			}
		}

		if( isset( $args['id'] ) ) {
			if( ( !$wgWikiaVETLoaded ) && get_class( $wgUser->getSkin() ) == 'SkinMonaco' ) {
				global $wgStylePath, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgUser, $wgHooks;			
				wfLoadExtensionMessages('VideoEmbedTool');
				$wgHooks['MakeGlobalVariablesScript'][] = 'VETSetupVars';
				$wgWikiaVETLoaded = true;
			}
		}

		if( isset( $args['id'] ) ) {
			if (count($videos) < 4) { // fill up 
				global $wgUser;
				for($i = count($videos); $i < 4; $i++) {
					if( get_class( $wgUser->getSkin() ) == 'SkinMonaco' ) {
						global $wgStylePath;
						$function = 'YAHOO.util.Get.script([wgExtensionsPath+\'/wikia/VideoEmbedTool/js/VET.js?\'+wgStyleVersion, stylepath+\'/common/yui_2.5.2/slider/slider-min.js?\'+wgStyleVersion], {onSuccess:function(o) { VET_show( o.data, ' . $args['id'] . ', ' . $i . ' )  }, data:YAHOO.util.Event.getEvent() }); YAHOO.util.Get.css( wgExtensionsPath+\'/wikia/VideoEmbedTool/css/VET.css?\'+wgStyleVersion )';
						

						$inside = '<a href="#" class="bigButton" style="margin-left: 105px; margin-top: 110px;" id="WikiaVideoGalleryPlaceholder' . $args['id'] . 'x' .  $i . '" onclick="' . $function . '"><big>' . wfMsg( 'wikiavideo-create' ) . '</big><small>&nbsp;</small></a>';
					} else { // todo maybe add some icon here not text, as we agreed
						$inside = wfMsg( 'wikiavideo-not-supported' );				
					}

					$out .= '<td><div class="gallerybox" style="width: 335px;"><div class="thumb" style="padding: 13px 0; width: 330px;"><div style="margin-left: auto; margin-right: auto; width: 300px; height: 250px;">' . $inside . '</div></div><div class="gallerytext"></div></div></td>';
					if($i%2 == 1) {
						$out .= '</tr><tr>';
					}
				}
			}
		}
		$out .= '</tr></table>';
	}
	return $out;
}

function WikiaVideo_makeVideo($title, $options, $sk, $wikitext = '') {
	global $wgWysiwygParserEnabled, $wgRequest;

	wfProfileIn('WikiaVideo_makeVideo');

	if(!$title->exists()) {
		//Wysiwyg: generate wikitext placeholder
		if (!empty($wgWysiwygParserEnabled)) {
			$out = Wysiwyg_SetRefId('placeholder', array('text' => $wikitext));
		}
		else {
			$out = $sk->makeColouredLinkObj(Title::newFromText('WikiaVideoAdd', NS_SPECIAL), 'new', $title->getPrefixedText(), 'name=' . $title->getDBKey());
		}
	} else {
		// get refId from Wysiwyg
		if (!empty($wgWysiwygParserEnabled)) {
			$refId = Wysiwyg_GetRefId($options, true);
		}
		else {
			$refId = 0;
		}

		$params = array_map( 'trim', explode( '|', $options) );

		//Wysiwyg: remove markers
		if (!empty($wgWysiwygParserEnabled)) {
			$params = array_map( create_function('$par', 'return preg_replace(\'%\x7f-wtb-(\d+)-\x7f(.*?)\x7f-wte-\1-\x7f%si\', \'\\2\', $par);'), $params);
		}	

		// defaults
		$width = 400;
		$thumb = false;
		$caption = '';

		foreach($params as $param) {

			$width_check = strpos($param, 'px');
			if($width_check > -1) {
				$width = str_replace('px', '', $param);
			} else if('thumb' == $param) {
				$thumb = true;
			} else if(('left' == $param) || ('right' == $param)) {
				$align = $param;
			} else {
				$caption = $param;
			}
		}

		if(empty($align)) {
			if($thumb) {
				$align = 'right';
			} else {
				$align = 'vetnone';
			}
		}

		$video = new VideoPage($title);
		$video->load();

		// generate different HTML for MW editor and FCK editor
		if (!empty($wgWysiwygParserEnabled)) {
			$out = $video->generateWysiwygWindow($refId, $title, $align, $width, $caption, $thumb);
		}
		else {
			$out = $video->generateWindow($align, $width, $caption, $thumb);
		}
	}
	wfProfileOut('WikiaVideo_makeVideo');
	return $out;
}

$wgHooks['MWNamespace:isMovable'][] = 'WikiaVideo_isMovable';
function WikiaVideo_isMovable($result, $index) {
	if($index == NS_VIDEO) {
		$result = false;
	}
	return true;
}

$wgHooks['ArticleFromTitle'][] = 'WikiaVideoArticleFromTitle';
function WikiaVideoArticleFromTitle($title, $article) {
	if(NS_VIDEO == $title->getNamespace()) {
		$article = new VideoPage($title);
	}
	return true;
}
