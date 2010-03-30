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

	// replace text and give Video:Template_Placeholder: text everywhere
	if ($text !== false) {
		$count = 0;
		$text = str_replace( $vid_tag, 'Video:Template_Placeholder', $text, $count );
		$wgWikiaVideosFoundInTemplates += $count;
	}
	return true;
}

function WikiaVideoWantedFilesGetSQL( $sql, $querypage, $name, $imagelinks, $page ) {
	global $wgExcludedWantedFiles;
	
	$where = "";
	if ( !empty($wgExcludedWantedFiles) && is_array($wgExcludedWantedFiles) ) {
		$dbr = wfGetDB( DB_SLAVE );
		$where = " and il_to not in (" . $dbr->makeList($wgExcludedWantedFiles) . ") ";
	}
	
	$sql = "SELECT $name as type, " . NS_FILE . " as namespace,il_to as title, COUNT(*) as value ";
	$sql .= "FROM $imagelinks ";
	$sql .= "LEFT JOIN $page ON il_to = page_title AND page_namespace = ". NS_FILE ." ";
	$sql .= "WHERE page_title IS NULL AND LOCATE(':', il_to) != 1 ";
	$sql .= $where;
	$sql .= "GROUP BY il_to ";
	
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
	global $wgExtraNamespaces, $wgWysiwygParserEnabled, $wgWikiaVideoGalleryId, $wgWikiaVideoPlaceholderId, $wgRTEParserEnabled;

	$wgWikiaVideoGalleryId = 0;
	$wgWikiaVideoPlaceholderId = 0;

	// macbre: don't touch anything when parsing for FCK
	if (!empty($wgWysiwygParserEnabled) || !empty($wgRTEParserEnabled)) {
		return true;
	}
	// fix for RT #22010
	$pattern1 = "/<videogallery[^>]+>/";
	$text = preg_replace( $pattern1, '<videogallery>', $text );

	$pattern2 = "/<videogallery/";
	$text = preg_replace_callback( $pattern2, 'WikiaVideoPreRenderVideoGallery', $text );
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
	$wgAutoloadClasses['VideoPageArchive'] = dirname(__FILE__). '/VideoPage.php';
}

function WikiaVideo_initParserHook(&$parser) {
	$parser->setHook('videogallery', 'WikiaVideo_renderVideoGallery');
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
		$out .= '<table class="gallery wikiaPlaceholder" cellspacing="0" cellpadding="0"><tr>';

		for($i = 0; $i < count($videos); $i++) {
			$videoID = $videos[$i][0]->getArticleID();
			$style = '';

			if ($videoID > 0){
				$video = new VideoPage($videos[$i][0]);
				$video->load();
				$html = $video->getEmbedCode().'</div></div><div class="gallerytext">'.(!empty($videos[$i][1]) ? $videos[$i][1] : '');
			} else {
				$sk = $wgUser->getSkin();
				$html = $sk->makeColouredLinkObj(Title::newFromText('WikiaVideoAdd', NS_SPECIAL), 'new', $videos[$i][0]->getPrefixedText(), 'name=' . $videos[$i][0]->getDBKey());;
				$style = "height: 250px;";
			}
			$out .= '<td><div class="gallerybox" style="width: 335px;"> <div class="thumb" style="padding: 13px 0pt; width: 330px;'.$style.'">'.$html.'</div></div></td>';

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
					$show = ' VET_show( $.getEvent(), ' . $args['id'] . ', ' . $i . ' ); ';
					$onclick = '$.loadYUI(  function() {if (typeof VET_show != \'function\' ){ $.getScript(wgExtensionsPath+\'/wikia/VideoEmbedTool/js/VET.js?\'+wgStyleVersion, function() { '.$show.' importStylesheetURI( wgExtensionsPath+\'/wikia/VideoEmbedTool/css/VET.css?\'+wgStyleVersion ) } ) } else {'.$show.'} } )';

					// render placeholder cell
					$out .= Xml::openElement('td');
					$out .= Xml::openElement('div', array(
						'class' => 'gallerybox',
						'style' => 'width: 335px', // TODO: move to static CSS file
					));
					$out .= Xml::openElement('div', array(
						'class' => 'thumb',
						'style' => 'height: 250px; padding: 13px 0; width: 330px', // TODO: move to static CSS file
					));

					// "Add video" green button
					$out .= Xml::openElement('a', array(
						'id' => "WikiaVideoGalleryPlaceholder{$args['id']}x{$i}",
						'class' => 'wikia-button',
						'style' => "top: 110px;position:relative;",
						'href' => '#',
						'onclick' => $onclick,
					));

					$out .= wfMsg('wikiavideo-create');
					$out .= Xml::closeElement('a');

					$out .= Xml::closeElement('div') . Xml::closeElement('div') . Xml::closeElement('td');

					// close row of gallery
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
	global $wgWysiwygParserEnabled, $wgRTEParserEnabled, $wgRequest;
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
			// register new metadata entry
			$refid = Wysiwyg_SetRefId('video_add', array('width' => $width, 'height' => $height, 'isAlign' => $isalign, 'isThumb' => $isthumb, 'original' => $wikitext), false, true);

		}
		else {
			$show =  ' VET_show( $.getEvent(), ' . -2  . ', ' . $wgWikiaVideoPlaceholderId . ','. $isalign .','. $isthumb .' ,'. $iswidth .', \''. htmlspecialchars($caption) .'\' ); ';
			$onclick= '$.loadYUI( function() { if (typeof VET_show != \'function\' ){  $.getScript(wgExtensionsPath+\'/wikia/VideoEmbedTool/js/VET.js?\'+wgStyleVersion, function() {'.$show.' importStylesheetURI( wgExtensionsPath+\'/wikia/VideoEmbedTool/css/VET.css?\'+wgStyleVersion ) }  ) }else{ '.$show.'} } )';
		}

		// render HTML (RT #21087)
		$html = '';

		// wrapping div
		$wrapperAttribs = array(
			'id' => "WikiaVideoPlaceholder{$wgWikiaVideoPlaceholderId}",
			'class' => 'gallerybox wikiaPlaceholder',
			'style' => 'clear:both',
		);

		if (isset($refid)) {
			$wrapperAttribs['refid'] = $refid;
		}

		$html .= Xml::openElement('div', $wrapperAttribs);

		// videobox with proper size
		$html .= Xml::openElement('div', array(
			'class' => "thumb videobox t{$align}",
			'style' => "height: {$height}px; width: {$width}px",
		));

		// "Add video" green button
		if (empty($plc_template)) {
			$html .= Xml::openElement('a', array(
				'id' => "WikiaVideoPlaceholderInner{$wgWikiaVideoPlaceholderId}",
				'class' => 'wikia-button',
				'style' => "top: {$tmarg}px;position:relative;",
				'href' => '#',
				'onclick' => !empty($onclick) ? $onclick : '',
			));

			$html .= wfMsg('wikiavideo-create');

			$html .= Xml::closeElement('a');
		}

		// caption
		if ($caption != '') {
			$html .= Xml::element('span', array('class' => 'thumbcaption'), $caption);
		}

		// close divs
		$html .= Xml::closeElement('div') .Xml::closeElement('div');

		// increase counter
		$wgWikiaVideoPlaceholderId++;

		// dirty hack for CK support
		if (!empty($wgRTEParserEnabled)) {
			$html = RTEParser::renderMediaPlaceholder(array(
				'type' => 'video-placeholder',
				'params' => array(
					'width' => $width,
					'height' => $height,
					'caption' => $caption,
					'align' => $align,

					// extra data to be passed to VET
					'isAlign' => $isalign,
					'isThumb' => $isthumb,
				),
				'wikitext' => $wikitext,
			));
		}

		wfProfileOut('WikiaVideo_makeVideo');
		return $html;
	}

	if(!$title->exists()) {
		//Wysiwyg: generate wikitext placeholder for not exisiting video
		if (!empty($wgWysiwygParserEnabled)) {
			$out = Wysiwyg_SetRefId('placeholder', array('text' => $wikitext));
		}
		else if (!empty($wgRTEParserEnabled)) {
			RTE::log(__METHOD__ . '::brokenVideoLink', $wikitext);

			// add broken-video link placeholder
			$dataIdx = RTEData::put('placeholder', array('type' => 'broken-video', 'wikitext' => $wikitext, 'title' => $title->getDBkey()));
			$out = RTEMarker::generate(RTEMarker::PLACEHOLDER, $dataIdx);
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

		// generate different HTML for MW editor and FCK/CK editor
		if (!empty($wgWysiwygParserEnabled)) {
			$out = $video->generateWysiwygWindow($refId, $title, $align, $width, $caption, $thumb, $frame);
		}
		else if (!empty($wgRTEParserEnabled)) {
			$out = $video->generateThumbForCK($wikitext, $title, $align, $width, $caption, $thumb, $frame);
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
