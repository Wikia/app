<?php

#
# Simple lyric parser extension for mediawiki.
# Written by Trevor Peacock, 1 June 2006
# version 0.2.1
# Tested on MediaWiki 1.6devel, PHP 5.0.5 (apache2handler)
#
# developed to support the notation of lyrics in mediawiki.
# see http://lyrics.wikia.com/User:TrevorP/Notation
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
#   require("extensions/lyric.php");
#

################################################################################
# Functions
#
# This section has no configuration, and can be ignored.
#

require_once 'extras.php';

################################################################################
# Extension Credits Definition
#
# This section has no configuration, and can be ignored.
#

if(isset($wgScriptPath))
{
$wgExtensionCredits["parserhook"][]=array(
  'name' => 'Lyric Extension',
  'version' => '0.2.1',
  'url' => 'http://wiki.peacocktech.com/wiki/LyricExtension',
  'author' => '[http://about.peacocktech.com/trevorp/ Trevor Peacock]',
  'description' => 'Adds features allowing easy notation of lyrics in mediawiki' );
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
	#Instruct mediawiki to call LyricExtension to initialise new extension
	$wgHooks['ParserFirstCallInit'][] = "lyricTag_InstallParser";
	$wgHooks['BeforePageDisplay'][] = "lyricTagCss";

	// Use this pre-existing Wikia-specific hook to apply the index policy changes after the defaults are set (which comes after parsing).
	$wgHooks['AfterViewUpdates'][] = "efApplyIndexPolicy";
}

function lyricTag_InstallParser( $parser ) {
	#install hook on the element <lyric>
	$parser->setHook("lyric", "renderLyricTag");
	$parser->setHook("lyrics", "renderLyricTag");
	return true;
}

function lyricTagCss($out)
{
	$css = <<<DOC
.lyricbox
{
	padding: 1em 1em 0;
	border: 1px solid silver;
	color: black;
	background-color: #ffffcc;
}
.lyricsbreak{
	clear:both;
}
DOC
;
	$out->addScript("<style type='text/css'>/*<![CDATA[*/\n".$css."\n/*]]>*/</style>");

	return true;
}

function renderLyricTag($input, $argv, $parser)
{
	wfProfileIn( __METHOD__ );

	#make new lines in wikitext new lines in html
	$transform = str_replace(array("\r\n", "\r","\n"), "<br/>", trim($input));

	$isInstrumental = (strtolower(trim($transform)) == "{{instrumental}}");


	// FogBugz 8675 - if a page is on the Gracenote takedown list, make it not spiderable (because it's not actually good content... more of a placeholder to indicate to the community that we KNOW about the song, but just legally can't display it).
	if(0 < preg_match("/\{\{gracenote[ _]takedown\}\}/i", $transform)){
		$parser->mOutput->setIndexPolicy( 'noindex' );
	}

	#parse embedded wikitext
	$transform = $parser->parse($transform, $parser->mTitle, $parser->mOptions, false, false)->getText();

	$retVal = "";
	$retVal.= gracenote_getNoscriptTag();
	$retVal.= "<div class='lyricbox'>";
	$retVal.= gracenote_obfuscateText($transform);
	$retVal.= "<div class='lyricsbreak'></div>\n"; // so that we can have stuff in the box (like videos & awards) even if the lyrics are short.
	$retVal.= "</div>";

	// Tell the Google Analytics code that this view was for non-Gracenote lyrics.
	$retVal.= gracenote_getAnalyticsHtml(GRACENOTE_VIEW_OTHER_LYRICS);

	wfProfileOut( __METHOD__ );
	return $retVal;
} // end renderLyricTag()

/**
 * The parser tag may have set a parser option (which gets cached in the parser-cache) indicating that
 * this page should have a certain index policy.
 */
function efApplyIndexPolicy($wikiPage){
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
