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
define('IMG_PLC_MIN_WIDTH', 100);
define('IMG_PLC_DEF_WIDTH', 150);

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
	}
	return false;
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
	$ns_translated = ImagePlaceholderTranslateNsImage();
	if( !$ns_translated ) {
		$ns_img = wfMsgForContent( 'imgplc-image' );
	} else {
		$ns_img = $ns_translated;
	}
	$img_tag = $ns_img . ':' . wfMsgForContent( 'imgplc-placeholder' );
//	$cn_img_tag = 

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
		} else if( ( $plc_tag != $part ) && ( $img_tag != $part ) ) {
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
        global $wgExtensionMessagesFiles, $wgWikiaImagePlaceholderId, $wgContLang;
	// Shortcuts
	$fp =& $frameParams;
	$hp =& $handlerParams;

	global $wgContLang, $wgUser, $wgThumbLimits, $wgThumbUpright, $wgWysiwygParserEnabled, $wgWysiwygMetaData;

	$refid = Wysiwyg_GetRefId($options, true); // strip refid
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
		if( ( 'left' == $fp['align']) || ('right' == $fp['align'] ) ) {
			$align = $fp['align'];
			('left' == $fp['align']) ? $isalign = 1 : $isalign = 2;
		}
	} else {
		( $thumb || $frame ) ? $align = 'right' : $align = ''; 
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
                $wysiwygAttr = " refid={$refid}";
                $onclick = '';		
        } else {
                $wysiwygAttr = '';
		$onclick = ' onclick="$.loadYUI( function() {$.getScript(wgExtensionsPath+\'/wikia/WikiaMiniUpload/js/WMU.js?\'+wgStyleVersion, function() { WMU_show( $.getEvent(), ' . -2  . ', ' . $wgWikiaImagePlaceholderId . ','. $isalign .','. $isthumb .' ,'. $iswidth .', \''. htmlspecialchars($caption) .'\' , \'' . htmlspecialchars($link) . '\' ); importStylesheetURI( wgExtensionsPath+\'/wikia/WikiaMiniUpload/css/WMU.css?\'+wgStyleVersion ) } ) } )"';
        }
	
	( $thumb || $frame ) ? $caption_line = '<div class="thumbcaption" style="width:' . ($width - 10) . 'px"><hr/>' . $caption . '</div>' : $caption_line = '';
        $out = '<div id="WikiaImagePlaceholder' . $wgWikiaImagePlaceholderId . '" class="gallerybox" style="clear:both; vertical-align: bottom;"' . $wysiwygAttr . '><div class="thumb t' . $align . ' videobox" style="padding: 0; position: relative; width: ' . $width . 'px; height: ' . $height . 'px;"><div style="margin-left: auto; margin-right: auto; width: ' . $width . 'px; height: ' . $height . 'px;" >';
	$out .= '<a href="#" class="bigButton" style="left: ' . $lmarg . 'px; position: absolute; top: ' . $tmarg . 'px;" id="WikiaImagePlaceholderInner' . $wgWikiaImagePlaceholderId  . '"'. $onclick . '><big>' . wfMsg( 'imgplc-create' ) . '</big><small>&nbsp;</small></a>' . $caption_line . '</div></div></div>';
        $wgWikiaImagePlaceholderId++;
        return $out;
}

// check if this is or not a placeholder
function ImagePlaceholderIsPlaceholder( $text ) {
        return ($text ==  wfMsgForContent( 'imgplc-placeholder' ) ) ;
}

