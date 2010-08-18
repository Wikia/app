<?php
/*
 * @author Bartek Łapiński
 */

if(!defined('MEDIAWIKI')) {
        exit(1);
}

$wgExtensionCredits['other'][] = array(
        'name' => 'Image Placeholder (Add Images)',
        'author' => 'Bartek Łapiński',
	'version' => '0.61',
);

global $wgWikiaImagesFoundInTemplates;

// minimal and default widths for placeholder box
define('IMG_PLC_MIN_WIDTH', 150);
define('IMG_PLC_DEF_WIDTH', 150);

// This should not be fully internationalized, as the text will remain in wikitext
// and changing the message would break the markup if we only use wfMsg.
define('IMG_PLC_PLACEHOLDER', 'Placeholder');

$dir = dirname(__FILE__).'/';

$wgExtensionFunctions[] = 'ImagePlaceholder_init';

$wgHooks['Parser::FetchTemplateAndTitle'][] = 'ImagePlaceholderFetchTemplateAndTitle';
$wgHooks['ImageBeforeProduceHTML'][] = 'ImagePlaceholderImageBeforeProduceHTML';
$wgHooks['ParserBeforeStrip'][] = 'ImagePlaceholderParserBeforeStrip';
// this is a custom hook defined in Parser.php, of course required for it to work
$wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'ImagePlaceholderBeforeParserMakeImageLinkObjOptions';

function ImagePlaceholderFetchTemplateAndTitle( $text, $finalTitle ) {
        global $wgContLang, $wgWikiaImagesFoundInTemplates;
        $img_tag = $wgContLang->getFormattedNsText( NS_FILE ) . ':' . wfMsg( 'imgplc-placeholder' );
	// todo NS_IMAGE!

        if ($text !== false) {
                $count = 0;
                $text = str_replace( $img_tag, 'File:Template_Placeholder', $text, $count );
                $wgWikiaImagesFoundInTemplates += $count;
        }
        return true;
}

function ImagePlaceholder_init() {
        global $wgAutoloadClasses, $wgExtensionMessagesFiles;
	$wgExtensionMessagesFiles['ImagePlaceholder'] = dirname(__FILE__).'/ImagePlaceholder.i18n.php';
        wfLoadExtensionMessages('ImagePlaceholder');
	$wgWikiaImagesFoundInTemplates = 0;
}

function ImagePlaceholderTranslateNsImage() {
	global $wgContLang;
	$aliases = $wgContLang->namespaceAliases;
	$aliases = array_flip( $aliases );
	if ( !empty( $aliases[ NS_FILE ] ) ) {
        	return $aliases[ NS_FILE ]; # Image:
	} else {
		return wfMsgForContent( 'imgplc-image' );
	}
}

// this function is to bypass the default MW parameter handling, because it assumes we have an actual file on the way
// it passes $params array by reference to be used later
function ImagePlaceholderBeforeParserMakeImageLinkObjOptions( $parser, $title, $parts, $params, $time, $descQuery, $options ) {
	// we have to ready the parameters and then fire up makeLink, heh
	// other way parameters are mangled

	if( !ImagePlaceholderIsPlaceholder( $title->getText() ) ){
		return true;
	}
	global $wgContLang;
	$plc_tag = $wgContLang->getFormattedNsText( NS_FILE ) . ':' . wfMsgForContent( 'imgplc-placeholder' );
	$ns_img = ImagePlaceholderTranslateNsImage();
	$img_tag = $ns_img . ':' . wfMsgForContent( 'imgplc-placeholder' );

	$params = array(
		'frame' => array(),
		'handler' => array(),
		'horizAlign' => array(),
		'vertAlign' => array()
	);

	$horizAlign = array( 'left', 'right', 'center', 'none' );
	$caption = '';
	$params['handler']['options'] = $options;

	foreach( $parts as $part ) {
		if( 'thumb' == $part ) {
			$params['frame']['thumbnail'] = '';
		} elseif ( 'frame' == $part ) {
			$params['frame']['frame'] = '';
		} elseif( in_array( $part, $horizAlign ) ) {
			$params['frame']['align'] = $part;
			$params['horizAlign'][$part] = '';
		} elseif( 0 === strpos( $part, 'link=' ) ) {
			$params['frame']['link'] = substr( $part, 5 );
		} elseif( preg_match( '/^([0-9]*)x([0-9]*)\s*(?:px)?\s*$/', $part, $m ) ) { // width we have
			$params['handler']['width'] = intval( $m[1] ) ;
		} elseif ( preg_match( '/^[0-9]*\s*(?:px)?\s*$/', $part ) ) {
			$params['handler']['width'] = intval( $part );
		} else if( ( mb_strtolower($plc_tag) != mb_strtolower($part) /* RT #35575 */ ) && ( $img_tag != $part ) ) {
			$params['frame']['caption'] = $part;
		}
	}

	return false;
}

function ImagePlaceholderParserBeforeStrip($parser, $text, $strip_state) {
	global $wgWikiaImagePlaceholderId;

	$wgWikiaImagePlaceholderId = 0;
	return true;
}

// function that calls our custom placeholder maker and bypasses default MW image construction functionality
function ImagePlaceholderImageBeforeProduceHTML( $skin, $title, $file, $frameParams, $handlerParams, $time, $res ) {
        if( ImagePlaceholderIsPlaceholder( $title->getText() ) ) {
                $res = ImagePlaceholderMakePlaceholder( $file, $frameParams, $handlerParams );
                return false;
        }
	return true;
}

// return empty string, this is for placeholders in templates
function ImagePlaceholder_makeDullImage( $title, $options, $holders = false ) {
	global $wgExtensionMessagesFiles, $wgWikiaVideoPlaceholderId, $wgContLang;

	// return none, null, zero
	return '';
}

// generate the placeholder box based on given parameters
function ImagePlaceholderMakePlaceholder( $file, $frameParams, $handlerParams ) {

	wfProfileIn(__METHOD__);

        global $wgRequest,$wgExtensionMessagesFiles, $wgWikiaImagePlaceholderId, $wgContLang;
	// Shortcuts
	$fp =& $frameParams;
	$hp =& $handlerParams;

	global $wgContLang, $wgUser, $wgThumbLimits, $wgThumbUpright, $wgWysiwygParserEnabled, $wgWysiwygMetaData;

	if ( !empty( $wgWysiwygParserEnabled ) ) {
		$refid = Wysiwyg_GetRefId($options, true); // strip refid
	}
	$plc_tag = '';
	$plc_tag = $wgContLang->getFormattedNsText( NS_FILE ) . ':' . wfMsgForContent( 'imgplc-placeholder' );
	( isset( $hp['options'] ) && ( '' != $hp['options'] ) ) ? $wikitext = '[[' . $plc_tag . '|' . $hp['options'] . ']]' : $wikitext = '[[' . $plc_tag . ']]';

	$prefix = $postfix = '';

	$thumb = false;
	$frame = false;
	$caption = '';
	$link = '';
	$align = '';
	$isalign = 0;
	$isthumb = 0;
	$iswidth = 0;
	$iscaption = 0;
	$islink = 0;
	if( isset( $hp['width'] ) && ( 0 != $hp['width'] ) ) { // FCK takes 0
		$width = $hp['width'];
		// if too small, the box will end up looking... extremely silly
		if( $width < IMG_PLC_MIN_WIDTH ) {
			$width = IMG_PLC_MIN_WIDTH;
		}
		$iswidth = $width;
	} else {
		$width = IMG_PLC_DEF_WIDTH;
	}

	$height = $width;
	if ( isset( $fp['thumbnail'] ) ) {
	        $thumb = true;
		$isthumb = 1;
	}
	if ( isset( $fp['frame'] ) ) {
	        $frame = true;
	}
	if( isset( $fp['align'] ) ) {
		if( ( 'left' == $fp['align']) || ('right' == $fp['align'] ) || ('center' == $fp['align'] ) ) {
			$align = $fp['align'];
			('left' == $fp['align']) ? $isalign = 1 : $isalign = 2;
		}
	} else {
		( $thumb || $frame ) ? $align = 'right' : $align = '';
	}
	// set margin accordingly to alignment, identical to normal Image: -- RT#21368
	// FIXME: this REALLY should be done in a class
	$margin = '';
	if( isset( $align ) ) {
		if ( $align == 'right' ) {
			$margin = 'margin: 0.5em 0 1.2em 1.4em;';
		} else if ( $align == 'center' ) {
			$margin = 'margin: 0.5em auto 1.2em;';
		} else {
			$margin = 'margin: 0.5em 1.4em 1.2em 0;';
		}
	}

	if ( isset( $fp['caption'] ) ) {
	        $caption = $fp['caption'];
		$iscaption = 1;
	}

	if ( isset( $fp['link'] ) ) {
	        $link = $fp['link'];
		$islink = 1;
	}

	$height =  $width;
	// this is for positioning the "Add Image" button
	$lmarg = ceil( ( $width - 90 ) / 2 );
	$tmarg = ceil( ( $height - 30 ) / 2 );

	// macbre: Wysiwyg support for video placeholder
	if (!empty($wgWysiwygParserEnabled)) {
		$refid = Wysiwyg_SetRefId('image_add', array( 'width' => $iswidth, 'height' => $height, 'isAlign' => $isalign, 'isThumb' => $isthumb, 'original' => $wikitext, 'caption' => $caption, 'link' => $link ), false, true);
	} else {
		if( ($wgRequest->getVal('diff',0) == 0) && ($wgRequest->getVal('oldid',0) == 0) ) {
			$onclick = 'WET.byStr(\'articleAction/imageplaceholder\');$.loadYUI( function() {$.getScript(wgExtensionsPath+\'/wikia/WikiaMiniUpload/js/WMU.js?\'+wgStyleVersion, function() { WMU_show( $.getEvent(), ' . -2  . ', ' . $wgWikiaImagePlaceholderId . ','. $isalign .','. $isthumb .' ,'. $iswidth .', \''. htmlspecialchars($caption) .'\' , \'' . htmlspecialchars($link) . '\' ); importStylesheetURI( wgExtensionsPath+\'/wikia/WikiaMiniUpload/css/WMU.css?\'+wgStyleVersion ) } ) } )';
		} else {
			$onclick = 'alert('.escapeshellarg(wfMsg('imgplc-notinhistory')).'); return false;';
		}
	}

	// FIXME: argh! inline styles! Move to classes someday... --TOR
	$margin = '';
	$additionalClass = '';
	if( isset( $align ) ) {
		if ( $align == 'right' ) {
			$margin = 'margin: 0.5em 0 1.2em 1.4em;';
		} else if ( $align == 'center' ) {
			$margin = 'margin: 0.5em auto 1.2em;';
			$additionalClass = ' center';
		} else {
			$margin = 'margin: 0.5em 1.4em 1.2em 0;';
		}
	}

	// render HTML (RT #21087)
	$out = '';

	$wrapperAttribs = array(
		'id' => "WikiaImagePlaceholder{$wgWikiaImagePlaceholderId}",
		'class' => "gallerybox wikiaPlaceholder{$additionalClass}",
		'style' => 'clear:both; vertical-align: bottom', // TODO: move to static CSS file
	);

	if (isset($refid)) {
		$wrapperAttribs['refid'] = $refid;
	}

	$out .= Xml::openElement('div', $wrapperAttribs);
	$out .= Xml::openElement('div', array(
		'class' => "thumb t{$align} videobox", // TODO: maybe change class name (videobox)
		'style' => "height: {$height}px; width: {$width}px; {$margin}",
	));

	// "Add video" green button
	$out .= Xml::openElement('a', array(
		'id' => "WikiaImagePlaceholderInner{$wgWikiaImagePlaceholderId}",
		'class' => 'wikia-button',
		'style' => "top: {$tmarg}px;position:relative;",
		'href' => '#',
		'onclick' => !empty($onclick) ? $onclick : '',
	));

	$out .= wfMsg('imgplc-create');
	$out .= Xml::closeElement('a');

	// caption (RT #47460)
	if ($caption != '') {
		$out .= Xml::element('span', array('class' => 'thumbcaption'), $caption);
	}

	$out .= Xml::closeElement('div') . Xml::closeElement('div') . Xml::closeElement('td');

	// increase counter
        $wgWikiaImagePlaceholderId++;

	// dirty hack for CK support
	global $wgRTEParserEnabled;
	if (!empty($wgRTEParserEnabled)) {
		$out = RTEParser::renderMediaPlaceholder(array(
			'type' => 'image-placeholder',
			'params' => array(
				'width' => $width,
				'height' => $height,
				'caption' => $caption,
				'align' => $align,

				// extra data to be passed to WMU
				'isAlign' => $isalign,
				'isThumb' => $isthumb,
			)
		));
	}

	wfProfileOut(__METHOD__);

        return $out;
}

// check if this is or not a placeholder
function ImagePlaceholderIsPlaceholder( $text ) {
	if ( $text == wfMsgForContent( 'imgplc-placeholder' )
	  || $text == IMG_PLC_PLACEHOLDER ) {
		return true;
	}

	return false;
}
