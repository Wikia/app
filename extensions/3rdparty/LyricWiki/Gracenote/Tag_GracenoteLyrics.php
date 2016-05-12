<?php

# Gracenote licensing-compliant lyrics parser extension for MediaWiki.
# This extension allows for copy-protection during display as well as for
# appropriate tracking-tags for the current song and required Gracenote branding.
# Written by Sean Colombo, 9 September 2009.
#
# Based heavily on the simple lyric parser extension for mediawiki.
# Written by Trevor Peacock, 1 June 2006
#
#
# Features:
#  * Allows basic lyric notation
#  * Optional CSS styling embedded in every page
#  * CSS styling not embedded in meta tage, rather @import-ed from extension file
#
# To install, copy this file into "extensions" directory, and add
# the following line to the end of LocalSettings.php
# (above the  ? >  )
#
#   require("extensions/LyricWiki/Tag_GracenoteLyrics.php");
#

// ISSUES TO KEEP IN MIND AND DISCUSS WITH WIKIA:
// TRACKING:
//  - I have to add the code below (the #vardefine... etc.) into the Song template but only after DPL is installed - http://lyrics.wikia.com/index.php?title=Template:Song&action=edit
//	- This tracking requires the advanced "ga.js" code which Google explicitly says not to use on the same page as "urchin.js" code which is there now. They say this can lead to errors.
//	  The documentation touches on a way to do both at once but it's just in the form of a vaguely documented function: http://code.google.com/intl/en-US/apis/analytics/docs/gaJS/gaJSApiUrchin.html#_gat.GA_Tracker_._setRemoteServerMode
// COPY PROTECTION:
//	- One of the requirements specified is "Save As" but it appears that there aren't even futile methods to do this.

// TODO: Copy protection
//		TODO: No-cache headers: http://www.codeave.com/html/code.asp?u_log=5080 (check with Artur to see if this will destroy Varnish's ability to cache the site). My guess is that the intention is just to prevent cached pages from being used instead of ads (but the ads aren't cached) so unless they actually think a user could dig through their browser's cache to find the page more easily than just searching for it again...
# Copy-prevention measures in this extension:
#		Clear-clipboard script is enabled for IE 6.  No modern browsers support it in a way that would prevent print-screens.
#		Print CSS should disabled and some text which is normally hidden which will explain this issue when printed (or print previewed).
#		No CTRL-A script.
#		No text-select script for all 'lyricbox' divs on page.
#		Robots.txt doesn't appear to be a real requirement (probably because the competitors listed don't have bots). For example, this is Metrolyrics' robots file: http://www.metrolyrics.com/robots.txt
#		Transform text into encoded unicode values for the content of the tag so that View Source will look very unhelpful.

// Tracking
//		The tracking code requires this in the Song template (it is in there right now)
//{{#vardefine:gracenoteid|{{#ifexist: Gracenote:{{PAGENAME}}|
//{{#dpl:title=Gracenote:{{PAGENAME}}
//|mode=userformat
//|allowcachedresults=true
//|includepage={GracenoteHeader}:gracenoteid
//}}}}
//}}
//<div id='gracenoteid'>{{#if:{{#var:gracenoteid}}|{{#var:gracenoteid}}|{{PAGENAME}}}}</div>

// The following style or something similar should be in MediaWiki:Common.css for this extension to work as intended:
///* Gracenote page header boxes */
//.gracenote-header {
//   background-color:#ffff80;
//   border:2px #000 solid;
//   padding:15px;
//   font-weight:bold;
//   text-align:center;
//   width:auto;
//   margin:0 auto;
//}
///* The line for Gracenote songwriter and publisher credits. */
//.gracenote-credits {
//   font-weight:bold;
//   color:#888;
//   background-color:#eee;
//}
///* Just used to hold Gracenote ID so that JS can pick it up & send it later. */
//#gracenoteid{
//display:none;
//}
//
//.print-disabled-notice{display:none;}
//@media print{
//.lyricbox{display:none;}
//.print-disabled-notice{display:table;}
//}
//


################################################################################
# Functions
#
# This section has no configuration, and can be ignored.
#

# uncomment for local testing
#include( 'extras.php' );
include_once "$IP/extensions/3rdparty/LyricWiki/extras.php";
include_once 'Gracenote.php';

################################################################################
# Extension Credits Definition
#
# This section has no configuration, and can be ignored.
#

if(isset($wgScriptPath))
{
$wgExtensionCredits["parserhook"][]=array(
  'name' => 'Gracenote Lyric-Display Extension',
  'version' => '0.0.1',
  'url' => '',
  'author' => '[http://about.peacocktech.com/trevorp/ Trevor Peacock] for original Lyric Extension, [http://www.seancolombo.com Sean Colombo] for Gracenote version.',
  'description' => 'Adds features allowing easy display of Gracenote lyrics in MediaWiki with all required tracking and copy-protection required by licensing agreement.' );
}

################################################################################
# Lyric Render Section
#
# This section has no configuration, and can be ignored.
#
# This section renders <lyric> tags. It forces a html break on every line,
# and styles the section with a css id.
# this id can either be in the mediawiki css files, or defined by the extension
#

if(isset($wgScriptPath))
{
	#Instruct mediawiki to call gracenoteLyricsTag to initialise new extension
	$wgHooks['ParserFirstCallInit'][] = "gracenoteLyricsTag";
	$wgHooks['BeforePageDisplay'][] = "gracenoteLyricsTagCss";

	// This only needs to be included once between the Lyrics tag and the GracenoteLyrics tag.
	$wgHooks['SkinAfterBottomScripts'][] = 'gracenote_outputGoogleAnalytics';

	// Use this pre-existing Wikia-specific hook to apply the index policy changes after the defaults are set (which comes after parsing).
	$wgHooks['AfterViewUpdates'][] = "efGracenoteApplyIndexPolicy";
}

#Install extension
function gracenoteLyricsTag( Parser &$parser)
{
  #install hook on the element <gracenotelyrics>
  $parser->setHook("gracenotelyrics", "renderGracenoteLyricsTag");

  return true;
}


function gracenoteLyricsTagCss(OutputPage $out)
{
	$css = <<<DOC
.lyricbox
{
	padding: 1em;
	border: 1px solid silver;
	color: black;
	background-color: #ffffcc;
}
DOC
;
	$out->addScript("<style type='text/css'>/*<![CDATA[*/\n".$css."\n/*]]>*/</style>");

	return true;
}

function renderGracenoteLyricsTag($input, $argv, Parser $parser)
{
	#make new lines in wikitext new lines in html
	$transform = str_replace(array("\r\n", "\r","\n"), "<br />", trim($input));

	$isInstrumental = (strtolower(trim($transform)) == "{{instrumental}}");

	GLOBAL $wgExtensionsPath;
	$imgPath = "$wgExtensionsPath/3rdparty/LyricWiki";
	$artist = $parser->mTitle->getDBkey();
	$colonIndex = strpos("$artist", ":");
	$songTitle = $parser->mTitle->getText();
	$artistLink = $artist;
	$songLink = $songTitle;
	if($colonIndex !== false){
		$artist = substr($artist, 0, $colonIndex);
		$songTitle = substr($songTitle, $colonIndex+1);

		$artistLink = str_replace(" ", "+", $artist);
		$songLink = str_replace(" ", "+", $songTitle);
	}
	$artistLink = str_replace("_", "+", $artistLink);
	$songLink = str_replace("_", "+", $songLink);

	// FogBugz 8675 - if a page is on the Gracenote takedown list, make it not spiderable (because it's not actually good content... more of a placeholder to indicate to the community that we KNOW about the song, but just legally can't display it).
	if(0 < preg_match("/\{\{gracenote[ _]takedown\}\}/i", $transform)){
		$parser->mOutput->setIndexPolicy( 'noindex' );
	}

	#parse embedded wikitext
	$retVal = "";
	$transform = $parser->parse($transform, $parser->mTitle, $parser->mOptions, false, false)->getText();

	$retVal.= gracenote_getNoscriptTag();

	$retVal.= "<div class='lyricbox'>";
	$retVal.= gracenote_obfuscateText($transform);
	$retVal.= "</div>";
	$retVal.= gracenote_getPrintDisabledNotice();

	// Required Gracenote branding.
	$retVal.= gracenote_getBrandingHtml();

	// Tell the Google Analytics code that this view was for Gracenote lyrics.
	$retVal.= gracenote_getAnalyticsHtml(GRACENOTE_VIEW_GRACENOTE_LYRICS);

	return $retVal;
}

/**
 * The parser tag may have set a parser option (which gets cached in the parser-cache) indicating that
 * this page should have a certain index policy.
 *
 * @param $wikiPage WikiPage
 */
function efGracenoteApplyIndexPolicy($wikiPage){
	global $wgUser;
	wfProfileIn( __METHOD__ );

	$parserOptions = $wikiPage->makeParserOptions( $wgUser );
	$parserOutput = $wikiPage->getParserOutput( $parserOptions );
	if(is_object($parserOutput)){
		$indexPolicy = $parserOutput->getIndexPolicy();
		if(!empty($indexPolicy)){
			global $wgOut;
			$wgOut->setIndexPolicy($indexPolicy);
		}
	}

	wfProfileOut( __METHOD__ );
	return true;
} // end efApplyIndexPolicy()
