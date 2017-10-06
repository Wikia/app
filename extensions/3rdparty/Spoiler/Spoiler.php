<?php
# WikiMedia spoiler extension
# <spoiler> some text </spoiler>
# the function registered by the extension hides the text between the
# tags behind a JavaScript spoiler block.
#
# (C) Copyright 2006, Brian Enigma <brian@netninja.com>
# This work is licensed under a Creative Commons Attribution-Noncommercial-Share
# Alike 2.5 License.  Some rights reserved.
# http://creativecommons.org/licenses/by-nc-sa/2.5/

# Modified February 2007 by Patrick Delancy for use in TibiaWiki ( http://tibia.erig.net/ )

$wgHooks['ParserFirstCallInit'][] = "wfSpoilerExtension";
$wgHooks['OutputPageBeforeHTML'][] = 'spoilerParserHook' ;

/**
 * @param Parser $parser
 * @return bool
 */
function wfSpoilerExtension( $parser ) {
	# register the extension with the WikiText parser
	# the first parameter is the name of the new tag.
	# the second parameter is the callback function for
	# processing the text between the tags
	$parser->setHook( "spoiler", "renderSpoiler" );
	return true;
}

function wfSpoilerJavaScript() {
	return	"<script type=\"text/javascript\" language=\"JavaScript\">\n" .
				"\n" .
				"function getStyleObject(objectId) {\n" .
				"    // checkW3C DOM, then MSIE 4, then NN 4.\n" .
				"    //\n" .
				"    if(document.getElementById) {\n" .
				"      if (document.getElementById(objectId)) {\n" .
				"	     return document.getElementById(objectId).style;\n" .
				"      }\n" .
				"    } else if (document.all) {\n" .
				"      if (document.all(objectId)) {\n" .
				"	     return document.all(objectId).style;\n" .
				"      }\n" .
				"    } else if (document.layers) { \n" .
				"      if (document.layers[objectId]) { \n" .
				"	     return document.layers[objectId];\n" .
				"      }\n" .
				"    } else {\n" .
				"	   return false;\n" .
				"    }\n" .
				"}\n" .
				"\n" .
				"function toggleObjectVisibility(objectId) {\n" .
				"    // first get the object's stylesheet\n" .
				"    var styleObject = getStyleObject(objectId);\n" .
				"\n" .
				"    // then if we find a stylesheet, set its visibility\n" .
				"    // as requested\n" .
				"    //\n" .
				"    if (styleObject) {\n" .
				"        if (styleObject.visibility == 'hidden') {\n" .
				"            styleObject.visibility = 'visible';\n" .
				"            styleObject.position = 'relative';\n" .
				"        } else {\n" .
				"            styleObject.visibility = 'hidden';\n" .
				"            styleObject.position = 'absolute';\n" .
				"        }\n" .
				"        return true;\n" .
				"    } else {\n" .
				"        return false;\n" .
				"    }\n" .
				"}\n" .
				"</script>\n";
}

function spoilerParserHook( OutputPage $out , &$text ) {
	$text = wfSpoilerJavaScript() . $text;
	return true;
}

function wfMakeSpoilerId() {
	$result = "spoiler_";
	for ($i=0; $i<20; $i++)
		$result .= chr(rand(ord('A'), ord('Z')));
	return $result;
}

/**
 * The callback function for converting the input text to HTML output
 *
 * @param string $input
 * @param array $argv
 * @param Parser $parser
 * @return string
 */
function renderSpoiler( $input, $argv, $parser ) {
	# $argv is an array containing any arguments passed to the
	# extension like <example argument="foo" bar>..
	# Put this on the sandbox page:  (works in MediaWiki 1.5.5)
	#   <example argument="foo" argument2="bar">Testing text **example** in between the new tags</example>

	$outputObj = $parser->recursiveTagParse( $input );
	$spoilerId = Sanitizer::encodeAttribute( wfMakeSpoilerId() );

	// quick hack to get rid of 'undefined index' notices...
	foreach (array('collapsed', 'footwarningtext', 'headwarningtext', 'linktext') as $a)
	{
		if (!isset($argv[$a])) $argv[$a] = '';
	}

	$output  = "<span onClick=\"toggleObjectVisibility('" . $spoilerId . "'); return false;\" style=\"cursor:pointer; background-color:#ffdddd; color:#000000; font-weight:bold; padding:4px 4px 2px 4px; border:solid red 1px; line-height: 24px;\">";
	$output .= ( $argv["linktext"] == '' ? wfMessage( 'spoiler-showhide-label' )->escaped() : htmlspecialchars( $argv["linktext"] ) ) . "</span>";
	$output .= "<div id=\"" . $spoilerId . "\" style=\"visibility:visible; position:relative;\">";
	if (!in_array("hidewarning", array_values($argv))) {
		$output .= "<div style=\"border-top: 2px red solid; border-bottom: 2px red solid; padding:3px; line-height: 22px;\">";
		$output .= ( $argv["headwarningtext"] == '' ? wfMessage( 'spoiler-warning' )->parse() : htmlspecialchars( $argv["headwarningtext"] ) );
		$output .= "</div>";
	}
	$output .= "<div id=\"" . $spoilerId . "_content\" style=\"padding-top:4px; padding-bottom:4px;\">" . $outputObj . "</div>";
	if (!in_array("hidewarning", array_values($argv))) {
		$output .= "<div style=\"border-top: 2px red solid; border-bottom: 2px red solid; padding:3px; line-height: 22px;\">";
		$output .= ( $argv["footwarningtext"] == '' ? wfMessage( 'spoiler-endshere' )->parse() : htmlspecialchars( $argv["footwarningtext"] ) );
		$output .= "</div>";
	}
	$output .= "</div>";
	if ($argv["collapsed"] != "false") {
		$output .= "<script type=\"text/javascript\" language=\"JavaScript\">";
		$output .= "toggleObjectVisibility('" . $spoilerId . "');";
		$output .= "</script>";
	}

	return $output;
}
