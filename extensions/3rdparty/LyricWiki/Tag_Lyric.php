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
	$wgExtensionFunctions[] = "lyricTag";
	$wgHooks['ParserFirstCallInit'][] = "lyricTag_InstallParser";
	$wgHooks['BeforePageDisplay'][] = "lyricTagCss";

	// Use this pre-existing Wikia-specific hook to apply the index policy changes after the defaults are set (which comes after parsing).
	$wgHooks['AfterViewUpdates'][] = "efApplyIndexPolicy";
}

#Install extension
function lyricTag()
{
	// Keep track of whether this is the first <lyric> tag on the page - this is to prevent too many Ringtones ad links.
	global $wgFirstLyricTag;
	$wgFirstLyricTag = true;
}

function lyricTag_InstallParser( $parser ) {
	#install hook on the element <lyric>
	$parser->setHook("lyric", "renderLyricTag");
	$parser->setHook("lyrics", "renderLyricTag");
	$parser->setHook("tonefuze", "renderToneFuzeTag");
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

	// If appropriate, build ringtones links.
	GLOBAL $wgFirstLyricTag, $wgLyricTagDisplayRingtone;
	$ringtoneLink = "";

	// For whatever reason, the links were not showing up after page-edits.
	// It seems that the parser is called multiple-times when saving a page-edit.
	$wgFirstLyricTag = true;

	$retVal = "";
	// NOTE: we put the link here even if wfAdPrefs_doRingtones() is false since ppl all share the article-cache, so the ad will always be in the HTML.
	// If a user has ringtone-ads turned off, their CSS will make the ad invisible.
	if( !empty( $wgLyricTagDisplayRingtone ) && $wgFirstLyricTag ){
		GLOBAL $wgExtensionsPath;
		$imgPath = "$wgExtensionsPath/3rdparty/LyricWiki";
		$artist = $parser->mTitle->getDBkey();
		$colonIndex = strpos("$artist", ":");
		$songTitle = "";
		if($colonIndex !== false){
			$artist = substr($artist, 0, $colonIndex);
			$songTitle = $parser->mTitle->getText();
			$songTitle = substr($songTitle, $colonIndex+1);
		}

		// The links have different adunit_ids above/below lyrics now. This will differentiate them for tracking.
		$aboveLink = getToneFuzeLink($isAboveLyrics=true, $artist, $songTitle);
		$belowLink = getToneFuzeLink($isAboveLyrics=false, $artist, $songTitle);

		$wgFirstLyricTag = false;
	}

	// FogBugz 8675 - if a page is on the Gracenote takedown list, make it not spiderable (because it's not actually good content... more of a placeholder to indicate to the community that we KNOW about the song, but just legally can't display it).
	if(0 < preg_match("/\{\{gracenote[ _]takedown\}\}/i", $transform)){
		$parser->mOutput->setIndexPolicy( 'noindex' );
	}

	#parse embedded wikitext
	$transform = $parser->parse($transform, $parser->mTitle, $parser->mOptions, false, false)->getText();

	$retVal.= gracenote_getNoscriptTag();
	$retVal.= "<div class='lyricbox'>";
	$retVal.= ($isInstrumental?"":$aboveLink); // if this is an instrumental, just a ringtone link on the bottom is plenty.
	$retVal.= gracenote_obfuscateText($transform);
	$retVal.= $belowLink;
	$retVal.= "<div class='lyricsbreak'></div>\n"; // so that we can have stuff in the box (like videos & awards) even if the lyrics are short.
	$retVal.= "</div>";

	// Tell the Google Analytics code that this view was for non-Gracenote lyrics.
	$retVal.= gracenote_getAnalyticsHtml(GRACENOTE_VIEW_OTHER_LYRICS);

	wfProfileOut( __METHOD__ );
	return $retVal;
} // end renderLyricTag()

/**
 * Parses <tonefuze> tag. This tag just lets us lay out the location of
 * the tone-fuze ads more easily on artist pages. The tonefuze ads are
 * automatically injected into lyrics pages by the <lyrics> tag.
 */
function renderToneFuzeTag($input, $argv, $parser){
	wfProfileIn( __METHOD__ );
	
	// Find out if this tag is above or below main content of the page (either lyrics or artist discog).
	$isAbove = (isset($argv['location']) && ($argv['location'] == "above"));

	// Parse out artist and/or song-title from the page title.
	$artist = $parser->mTitle->getDBkey();
	$colonIndex = strpos("$artist", ":");
	$songTitle = "";
	if($colonIndex !== false){
		$artist = substr($artist, 0, $colonIndex);
		$songTitle = $parser->mTitle->getText();
		$songTitle = substr($songTitle, $colonIndex+1);
	}
	$retVal = getToneFuzeLink($isAbove, $artist, $songTitle);	
	
	wfProfileOut( __METHOD__ );
	return $retVal;
} // end renderToneFuzeTag()

/**
 * Returns the HTML for a ToneFuze link for the given position, artist, and song title.
 * This can be used for artist pages or song pages.
 */
function getToneFuzeLink($isAboveLyrics=true, $artist, $songTitle=""){
	$ID_ABOVE_LYRICS = 39382076;
	$ID_BELOW_LYRICS = 39382077;
	$AD_ID_STRING = "AD_ID_STRING";
	$ringtoneLink = "";
	$ringtoneLink = "<script>";
	$ringtoneLink .= "(function() {";
	$ringtoneLink .= "var opts = {";
	$ringtoneLink .= "artist: \"{$artist}\",";
	$ringtoneLink .= "song: \"{$songTitle}\",";
	$ringtoneLink .= "adunit_id: {$AD_ID_STRING},";
	$ringtoneLink .= "div_id: \"cf_async_\" + Math.floor((Math.random() * 999999999))";
	$ringtoneLink .= "};";
	// For some reason "&" gets escaped, so we have to flip each term and the overall condition to get the same value (De Morgan's Law).
	$ringtoneLink .= "if(!(($('.ArticlePreview').length!== 0) || ($('.WikiaMainContent').length===0) || ($('.ve-spinner.visible').length!== 0))){"; // prevent this code from obliterating the preview & Visual Editor
		$ringtoneLink .= "document.write('<div id=\"'+opts.div_id+'\"></div>');var c=function(){cf.showAsyncAd(opts)};if(window.cf)c();else{cf_async=!0;var r=document.createElement(\"script\"),s=document.getElementsByTagName(\"script\")[0];r.async=!0;r.src=\"//srv.tonefuse.com/showads/showad.js\";r.readyState?r.onreadystatechange=function(){if(\"loaded\"==r.readyState||\"complete\"==r.readyState)r.onreadystatechange=null,c()}:r.onload=c;s.parentNode.insertBefore(r,s)};";
	$ringtoneLink .= "}";
	$ringtoneLink .= "})();";
	$ringtoneLink .= "</script>";
	
	if($isAboveLyrics){
		$ringtoneLink = str_replace($AD_ID_STRING, $ID_ABOVE_LYRICS, $ringtoneLink);
	} else {
		$ringtoneLink = str_replace($AD_ID_STRING, $ID_BELOW_LYRICS, $ringtoneLink);
	}

	return $ringtoneLink;
} // end getToneFuzeLink()

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
