<?php

#
# Simple lyric parser extension for mediawiki.
# Written by Trevor Peacock, 1 June 2006
# version 0.2.1
# Tested on MediaWiki 1.6devel, PHP 5.0.5 (apache2handler)
#
# developed to support the notation of lyrics in mediawiki.
# see http://lyricwiki.org/User:TrevorP/Notation
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
	$wgHooks['BeforePageDisplay'][] = "lyricTagCss";
}

#Install extension
function lyricTag()
{
  #install hook on the element <lyric>
  global $wgParser;
  $wgParser->setHook("lyric", "renderLyricTag");
  $wgParser->setHook("lyrics", "renderLyricTag");

  // Keep track of whether this is the first <lyric> tag on the page - this is to prevent too many Ringtones ad links.
  GLOBAL $wgFirstLyricTag;
  $wgFirstLyricTag = true;
}

function lyricTagCss($out)
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

function renderLyricTag($input, $argv, $parser)
{
  #make new lines in wikitext new lines in html
  $transform=str_replace(array("\r\n", "\r","\n"), "<br/>", trim($input));
  
  $isInstrumental = (strtolower(trim($transform)) == "{{instrumental}}");

  // If appropriate, build ringtones links.
  GLOBAL $wgFirstLyricTag;
  $ringtoneLink = "";
  // NOTE: we put the link here even if wfAdPrefs_doRingtones() is false since ppl all share the article-cache, so the ad will always be in the HTML.
  // If a user has ringtone-ads turned off, their CSS will make the ad invisible.
  if($wgFirstLyricTag){ 
	GLOBAL $wgTitle;
	$artist = $wgTitle->getDBkey();
	$colonIndex = strpos("$artist", ":");
	$songTitle = $wgTitle->getText();
	$artistLink = $artist;
	$songLink = $songTitle;
	if($colonIndex !== false){
		$artist = substr($artist, 0, $colonIndex);
		$songTitle = substr($songTitle, $colonIndex+1);
		
		$artistLink = str_replace(" ", "+", $artist);
		$songLink = str_replace(" ", "+", $songTitle);
	}
	$href = "<a href='http://www.ringtonematcher.com/co/ringtonematcher/02/noc.asp?sid=WILWros&amp;artist=".urlencode($artistLink)."&amp;song=".urlencode($songLink)."' target='_blank'>";
	$ringtoneLink = "";
	$ringtoneLink = "<div class='rtMatcher'>";
	$ringtoneLink.= "$href<img src='/phone_left.gif' alt='phone' width='16' height='17'/></a> ";
	$ringtoneLink.= $href."Send \"$songTitle\" Ringtone to your Cell</a>";
	$ringtoneLink.= " $href<img src='/phone_right.gif' alt='phone' width='16' height='17'/></a>";
	$ringtoneLink.= "</div>";
	$wgFirstLyricTag = false;
  }

	#parse embedded wikitext
	$retVal = ($isInstrumental?"":$ringtoneLink); // if this is an instrumental, just a ringtone link on the bottom is plenty.
	$retVal.= "<div class='lyricbox' >".$parser->parse($transform, $parser->mTitle, $parser->mOptions, false, false)->getText()."</div>";
	$retVal.= $ringtoneLink;
	return $retVal;
}

?>
