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
$wgHooks['UndeleteForm::showRevision'][] = 'WikiaVideoSpecialUndeleteSwitchArchive';
$wgHooks['UndeleteForm::showHistory'][] = 'WikiaVideoSpecialUndeleteSwitchArchive';
$wgHooks['UndeleteForm::undelete'][] = 'WikiaVideoSpecialUndeleteSwitchArchive';
$wgHooks['WantedFiles::getSQL'][] = 'WikiaVideoWantedFilesGetSQL';
$wgHooks['Parser::FetchTemplateAndTitle'][] = 'WikiaVideoFetchTemplateAndTitle';

$wgWikiaVideoGalleryId = 0;
$wgWikiaVETLoaded = false;
$wgWikiaVideosFoundInTemplates = 0;

function WikiaVideoFetchTemplateAndTitle( $text, $finalTitle ) {
	global $wgContLang, $wgWikiaVideosFoundInTemplates;

	$vid_tag = $wgContLang->getFormattedNsText( NS_VIDEO ) . ":Placeholder";

	// replace text and give Video_Template: namespace everywhere - because it's template...
	if ($text !== false) {
		$count = 0;
		$text = str_replace( $vid_tag, 'Video:Template_Placeholder', $text, $count );
		$wgWikiaVideosFoundInTemplates += $count;
	}
	return true;
}

function WikiaVideoWantedFilesGetSQL( $sql, $querypage, $name, $imagelinks, $page ) {
       	$sql = "
                        SELECT
                                $name as type,
                                " . NS_FILE . " as namespace,
                                il_to as title,
                                COUNT(*) as value
                        FROM $imagelinks
			LEFT JOIN $page ON il_to = page_title AND page_namespace = ". NS_FILE ."
			WHERE page_title IS NULL AND LOCATE(':', il_to) != 1
                        GROUP BY il_to
                        ";
        return true;
}

function WikiaVideoSpecialUndeleteSwitchArchive( $archive, $title ) {
	if( NS_VIDEO != $title->getNamespace() ) {
		return true;
	} else {
		$archive = new VideoPageArchive( $title );
	}
	return true;
}

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
	global $wgExtraNamespaces, $wgWysiwygParserEnabled, $wgWikiaVideoGalleryId, $wgWikiaVideoPlaceholderId;

	$wgWikiaVideoGalleryId = 0;
	$wgWikiaVideoPlaceholderId = 0;

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
			$wgExtraNamespaces[NS_VIDEO_TEMPLATE] = 'Video_Template';

	}
	$wgAutoloadClasses['VideoPage'] = dirname(__FILE__). '/VideoPage.php';
	$wgAutoloadClasses['VideoPageArchive'] = dirname(__FILE__). '/VideoPage.php';
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
						$function = '$.loadYUI( function() {$.getScript(wgExtensionsPath+\'/wikia/VideoEmbedTool/js/VET.js?\'+wgStyleVersion, function() { VET_show( $.getEvent(), ' . $args['id'] . ', ' . $i . ' ); importStylesheetURI( wgExtensionsPath+\'/wikia/VideoEmbedTool/css/VET.css?\'+wgStyleVersion ) } ) } )';

						$inside = '<a href="#" class="bigButton" style="margin-left: 105px; margin-top: 110px;" id="WikiaVideoGalleryPlaceholder' . $args['id'] . 'x' .  $i . '" onclick="' . $function . '"><big>' . wfMsg( 'wikiavideo-create' ) . '</big><small>&nbsp;</small></a>';
					} else {
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

function WikiaVideo_makeVideo( $title, $options, $sk, $wikitext = '', $plc_template = false ) {
	global $wgWysiwygParserEnabled, $wgRequest;

	wfProfileIn('WikiaVideo_makeVideo');

	// placeholder? treat differently
	if( ('Placeholder' == $title->getText() ) || ('Template Placeholder' == $title->getText() ) ) {
		// generate a single empty cell with a button
		global $wgExtensionMessagesFiles, $wgWikiaVideoPlaceholderId, $wgContLang;
		$wgExtensionMessagesFiles['WikiaVideo'] = dirname(__FILE__).'/WikiaVideo.i18n.php';
		wfLoadExtensionMessages( 'WikiaVideo' );

		if (!empty($wgWysiwygParserEnabled)) {
			$refid = Wysiwyg_GetRefId($options, true); // strip refid
		}

		$params = array_map( 'trim', explode( '|', $options ) );

		// defaults
		$width = 300;
		$thumb = false;
		$frame = false;
		$caption = '';
		$isalign = 0;
		$isthumb = 0;
		$iswidth = 0;
		$iscaption = 0;
		$plc_tag = $wgContLang->getFormattedNsText( NS_VIDEO ) . ":Placeholder";

		foreach($params as $param) {
			$width_check = strpos($param, 'px');
			if($width_check > -1) {
				$width = str_replace('px', '', $param);
				$iswidth = $width;
			} else if('thumb' == $param) {
				$thumb = true;
				$isthumb = 1;
			} else if('frame' == $param) {
				$thumb = true;
				$isthumb = 1;
				// frame is not covered here as per specs
			} else if(('left' == $param) || ('right' == $param)) {
				$align = $param;
				('left' == $param) ? $isalign = 1 : $isalign = 2;
			} else {
				if( $plc_tag != $param ) {
					$caption = $param;
					$iscaption = 1;
				}
			}
		}

		// height? we don't know the provider yet... I'll take youtube proportions for the time being
		$height = ceil( $width * 355 / 425 );
		$lmarg = ceil( ( $width - 90 ) / 2 );
		$tmarg = ceil( ( $height - 30 ) / 2 );

		if(empty($align)) {
			if($thumb) {
				$align = 'right';
				$isalign = 2;
			} else {
				$align = 'none';
			}
		}

		// macbre: Wysiwyg support for video placeholder
		if (!empty($wgWysiwygParserEnabled)) {
			$refid = Wysiwyg_SetRefId('video_add', array('width' => $width, 'height' => $height, 'isAlign' => $isalign, 'isThumb' => $isthumb, 'original' => $wikitext), false, true);

			$wysiwygAttr = " refid={$refid}";
			$onclick = '';
		} else {
				$wysiwygAttr = '';
				$onclick= ' onclick="$.loadYUI( function() {$.getScript(wgExtensionsPath+\'/wikia/VideoEmbedTool/js/VET.js?\'+wgStyleVersion, function() { VET_show( $.getEvent(), ' . -2  . ', ' . $wgWikiaVideoPlaceholderId . ','. $isalign .','. $isthumb .' ,'. $iswidth .', \''. htmlspecialchars($caption) .'\' ); importStylesheetURI( wgExtensionsPath+\'/wikia/VideoEmbedTool/css/VET.css?\'+wgStyleVersion ) } ) } )"';
		}

			$out = '<div id="WikiaVideoPlaceholder' . $wgWikiaVideoPlaceholderId . '" class="gallerybox" style="clear:both;"' . $wysiwygAttr . '><div class="thumb t' . $align . ' videobox" style="padding: 0; position: relative; width: ' . $width . 'px; height: ' . $height . 'px;"><div style="margin-left: auto; margin-right: auto; width: ' . $width . 'px; height: ' . $height . 'px;" >';
			if( !$plc_template ) {
				$out .= '<a href="#" class="bigButton" style="left: ' . $lmarg . 'px; position: absolute; top: ' . $tmarg . 'px;" id="WikiaVideoPlaceholderInner' . $wgWikiaVideoPlaceholderId  . '"'. $onclick . '><big>' . wfMsg( 'wikiavideo-create' ) . '</big><small>&nbsp;</small></a>'. $caption .'</div></div></div>';
			} else {
				$out .= '</div></div></div>';
			}
		wfProfileOut('WikiaVideo_makeVideo');
		$wgWikiaVideoPlaceholderId++;
		return $out;
	}

	if(!$title->exists()) {
		//Wysiwyg: generate wikitext placeholder for not exisiting video
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
		$frame = false;
		$caption = '';

		foreach($params as $param) {
			$width_check = strpos($param, 'px');
			if($width_check > -1) {
				$width = str_replace('px', '', $param);
			} else if('thumb' == $param) {
				$thumb = true;
			} else if('frame' == $param) {
				$thumb = true;
				$frame = true;
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
			$out = $video->generateWysiwygWindow($refId, $title, $align, $width, $caption, $thumb, $frame);
		}
		else {
			$out = $video->generateWindow($align, $width, $caption, $thumb, $frame);
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
