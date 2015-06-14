<?php
/*
 * @author Bartek Łapiński
 *
 * Note: This includes video and image placeholders
 */

if(!defined('MEDIAWIKI')) {
        exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name' => 'Image Placeholder (Add Images)',
	'author' => 'Bartek Łapiński',
	'version' => '0.61',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ImagePlaceholder',
	'descriptionmsg' => 'imgplc-desc'
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

/**
 * message files
 */
$wgExtensionMessagesFiles['ImagePlaceholder'] = $dir . 'ImagePlaceholder.i18n.php';

JSMessages::registerPackage('ImagePlaceholder', array('imgplc-*'));
JSMessages::enqueuePackage('ImagePlaceholder', JSMessages::EXTERNAL);

$wgHooks['ImageBeforeProduceHTML'][] = 'ImagePlaceholderImageBeforeProduceHTML';
$wgHooks['ParserBeforeStrip'][] = 'ImagePlaceholderParserBeforeStrip';

// this is a custom hook defined in Parser.php, of course required for it to work
$wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'ImagePlaceholderBeforeParserMakeImageLinkObjOptions';
$wgHooks['ParserShouldAddTrackingCategory'][] = 'ImagePlaceholderParserShouldAddTrackingCategory';

function ImagePlaceholder_init() {
	global $wgAutoloadClasses;
	$wgWikiaImagesFoundInTemplates = 0;
}

function ImagePlaceholderTranslateNsImage() {
	global $wgContLang;
	$aliases = $wgContLang->getNamespaceAliases();
	$aliases = array_flip( $aliases );
	if ( !empty( $aliases[ NS_FILE ] ) ) {
        	return $aliases[ NS_FILE ]; # Image:
	} else {
		return wfMsgForContent( 'imgplc-image' );
	}
}

function ImagePlaceholderParserShouldAddTrackingCategory( Parser $parser, Title $title, $file, &$shouldAddTrackingCategory ) {

	if( ImagePlaceholderIsPlaceholder( $title->getText() ) ){
		$shouldAddTrackingCategory = false;
	}
	return true;
}

// this function is to bypass the default MW parameter handling, because it assumes we have an actual file on the way
// it passes $params array by reference to be used later
function ImagePlaceholderBeforeParserMakeImageLinkObjOptions( Parser $parser, Title $title, $parts, &$params, $time, $descQuery, $options ) {
	// we have to ready the parameters and then fire up makeLink, heh
	// other way parameters are mangled

	if( !ImagePlaceholderIsPlaceholder( $title->getText() ) ){
		return true;
	}
	global $wgContLang;

	// TODO: This part of code, along with the ImagePlaceholderTranslateNsImage()
	// function has to be refined once Video and Image namespaces
	// are properly translated.

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
		} elseif( 'video' == $part ) {
			$params['handler']['isvideo'] = 1;
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
	global $wgWikiaImagePlaceholderId, $wgWikiaVideoPlaceholderId;

	$wgWikiaVideoPlaceholderId = 0;
	$wgWikiaImagePlaceholderId = 0;
	return true;
}

// function that calls our custom placeholder maker and bypasses default MW image construction functionality
function ImagePlaceholderImageBeforeProduceHTML( $skin, Title $title, $file, $frameParams, $handlerParams, $time, &$res ) {
	if( ImagePlaceholderIsPlaceholder( $title->getText() ) ) {
		$res = ImagePlaceholderMakePlaceholder( $file, $frameParams, $handlerParams );
		return false;
	}
	return true;
}

// return empty string, this is for placeholders in templates
function ImagePlaceholder_makeDullImage( $title, $options, $holders = false ) {
	// return none, null, zero
	return '';
}

// generate the placeholder box based on given parameters
function ImagePlaceholderMakePlaceholder( $file, $frameParams, $handlerParams ) {

	wfProfileIn(__METHOD__);

	global $wgRequest, $wgWikiaImagePlaceholderId, $wgWikiaVideoPlaceholderId, $wgContLang, $wgTitle;
	// Shortcuts
	$fp =& $frameParams;
	$hp =& $handlerParams;

	global $wgContLang, $wgUser, $wgThumbLimits, $wgThumbUpright, $wgRTEParserEnabled;

	$plc_tag = '';
	$plc_tag = $wgContLang->getFormattedNsText( NS_FILE ) . ':' . wfMsgForContent( 'imgplc-placeholder' );
	( isset( $hp['options'] ) && is_string($hp['options']) && ( '' != $hp['options'] ) ) ? $wikitext = '[[' . $plc_tag . '|' . $hp['options'] . ']]' : $wikitext = '[[' . $plc_tag . ']]';

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
	$isvideo = 0;

	if( !empty( $hp['isvideo'] ) ) {
		$isvideo = 1;
	}

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

	$additionalClass = '';

	if( $isvideo ) {
		$additionalClass .= ' wikiaVideoPlaceholder';
	} else {
		$additionalClass .= ' wikiaImagePlaceholder';
	}

	// render HTML (RT #21087)
	$out = '';

	$wrapperAttribs = array(
		'class' => "gallerybox wikiaPlaceholder{$additionalClass}",
	);

	// ImagePlaceholders still use id attribute, videos use data-id attribute. Images should be updated to match videos at some point
	if(!$isvideo) {
		$wrapperAttribs['id'] = "WikiaImagePlaceholder{$wgWikiaImagePlaceholderId}";
	}

	if (isset($refid)) {
		$wrapperAttribs['refid'] = $refid;
	}

	$out .= Xml::openElement('div', $wrapperAttribs);
	$out .= Xml::openElement('div', array(
		'class' => "thumb t{$align} videobox", // TODO: maybe change class name (videobox)
		'style' => "height: {$height}px; width: {$width}px;",
	));

	$linkAttrs = array(
		'id' => "WikiaImagePlaceholderInner{$wgWikiaImagePlaceholderId}",
		'class' => 'wikia-button',
		'style' => "top: {$tmarg}px;",
		'href' => ($wgTitle instanceof Title) ? $wgTitle->getLocalUrl( array( 'action' => 'edit') ) : '#',
		'data-id' => $isvideo ? $wgWikiaVideoPlaceholderId : $wgWikiaImagePlaceholderId,
		'data-align' => $isalign,
		'data-thumb' => $isthumb,
		'data-caption' => htmlspecialchars($caption),
		'data-width' => $width,
	);

	if( !$isvideo ) { // image placeholder
		$linkAttrs = array_merge($linkAttrs, array(
			'data-link' => htmlspecialchars($link),
			'data-width' => $width, // set only for images, let VET slider determine width for video
		));
	}

	$out .= Xml::openElement('a', $linkAttrs);

	$out .= $isvideo ? wfMsg('imgplc-add-video') : wfMsg('imgplc-add-image');
	$out .= Xml::closeElement('a');

	// caption (RT #47460)
	if ($caption != '') {
		$out .= Xml::element('span', array('class' => 'thumbcaption'), $caption);
	}

	$out .= Xml::closeElement('div') . Xml::closeElement('div') . Xml::closeElement('td');

	// increase counter
	if($isvideo) {
		$wgWikiaVideoPlaceholderId++;
	} else {
		$wgWikiaImagePlaceholderId++;
	}

	// dirty hack for CK support
	global $wgRTEParserEnabled;
	if (!empty($wgRTEParserEnabled)) {
		$out = RTEParser::renderMediaPlaceholder(array(
			'type' => $isvideo ? 'video-placeholder' : 'image-placeholder',
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
	} else {
		$out .= JSSnippets::addToStack(
			array( '/extensions/wikia/ImagePlaceholder/js/MediaPlaceholder.js' ),
			array(),
			'MediaPlaceholder.init'
		);
	}

	wfProfileOut(__METHOD__);
	return $out;
}

/* Used by WMU and VET. Match a placeholder image in the given $text.  The $box parameter determines
 * which placeholder is returned if there are more than one on the page.
 *
 * @param string $text Article text to check agains placeholder wikitext
 * @param int $box Index of placeholder to be replaced in case there's more than one on a page
 * @param bool $isVideo Check placeholder for existence of "|video"
 */

function MediaPlaceholderMatch ( $text, $box = 0, $isVideo = false ) {
	global $wgContLang;

	// Get the namesapace translations in the content language for files and videos
	$ns = NS_FILE;
	$ns_vid = $wgContLang->getFormattedNsText( $ns );
	$ns_img = ImagePlaceholderTranslateNsImage();

	// Get the same as above but for english
	$en_ns_vid = MWNamespace::getCanonicalName( $ns );

	$oldWgContLang = $wgContLang;
	$wgContLang = Language::factory( 'en' );
	$en_ns_img = ImagePlaceholderTranslateNsImage();
	$wgContLang = $oldWgContLang;

	// Get the placeholder text in both the content language and in english
	$placeholder_msg = wfMsgForContent( 'imgplc-placeholder' );
	$en_placeholder_msg = wfMsgReal( 'imgplc-placeholder', array(), true, 'en');

	$placeholder = '(?:' . implode('|', array(
			$ns_vid . ':' . $placeholder_msg,
			$ns_vid . ':' . $en_placeholder_msg,
			$ns_img . ':' . $placeholder_msg,
			$ns_img . ':' . $en_placeholder_msg,
			$en_ns_vid . ':' . $en_placeholder_msg,
			$en_ns_vid . ':' . $placeholder_msg,
			$en_ns_img . ':' . $en_placeholder_msg,
			$en_ns_img . ':' . $placeholder_msg)) . ')';

	preg_match_all( '/\[\[' . $placeholder . '[^\]]*\]\]/si', $text, $matches, PREG_OFFSET_CAPTURE );

	// Make sure we have matches and that there exists a match at index $box
	if ( is_array($matches) ) {
		$matchArr = $matches[0];

		for( $x = 0; $x < count( $matchArr ); $x++ ) {
			$match = $matchArr[$x];
			if( $isVideo ) {
				if ( !preg_match( '/\|video/', $match[0] ) ) {
					array_splice($matchArr, $x, 1);
				}
			} else {
				if ( preg_match( '/video/', $match[0] ) ) {
					array_splice($matchArr, $x, 1);
				}
			}
		}
		if ( count($matchArr) > $box ) {
			return $matchArr[$box];
		}
	}

	return null;
}

// check if this is or not a placeholder
function ImagePlaceholderIsPlaceholder( $text ) {
	if ( $text == wfMsgForContent( 'imgplc-placeholder' )
	  || $text == IMG_PLC_PLACEHOLDER ) {
		return true;
	}

	return false;
}
