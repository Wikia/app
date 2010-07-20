<?php
/**********************************************************************************

Copyright (C) 2008 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1,1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

***********************************************************************************

Version 0.1	2008-02-16
* Created - teknomunk
*/

function findFirstLetterOf($fLetterOf)
{
	$fLetterOf = strtoupper(trim($fLetterOf));
	$fLetter = strtoupper((strlen($fLetterOf) == 0)?"":substr($fLetterOf,0,1));
	
	if(is_numeric($fLetter))
	{
		return "0-9";
	}
	else if(($fLetter < "A") || ($fLetter > "Z"))
	{
		return "Symbol";
	}
	else
	{
		return $fLetter;
	}
}

function LyricWikiVariableDefaults()
{
	# default values
	$lwVars = Array();
	// TODO: It seems we may have implemented pagetype and pagetemplate backwards here and in Templates.php... right now a talk page for a song
	// will have a pagetype of "talk" and a pagetemplate of "song".  This seems backwards to me.  Should we flip it?
 	$lwVars["pagetype"] = "PAGETYPE";
 	$lwVars["pagetemplate"] = "PAGETEMPLATE";
	$lwVars["artist"] = "ARTIST";
	$lwVars["artistfletter"] = "ARTISTFLETTER";
	$lwVars["nativeartist"] = "NATIVEARTIST";
	$lwVars["romanartist"] = "ROMANARTIST";
	$lwVars["album"] = "ALBUM";
	$lwVars["albumyear"] = "ALBUMYEAR";
	$lwVars["albumfletter"] = "ALBUMFLETTER";
	$lwVars["song"] = "SONG";
	$lwVars["songfletter"] = "SONGFLETTER";
	$lwVars["artistsortname"] = "ARTISTSORTNAME";
	return $lwVars;
}

function parseLyricWikiTitle($titleStr,&$lwVars)
{
	$titleStr = preg_replace("/(\s)+/", "\\1", $titleStr); # remove duplicate spaces
	
	$isTalk = false;
	if(0 < preg_match("/^Talk:/", $titleStr, $matches)){
		$isTalk = true;
		$titleStr = substr($titleStr, 5);
	}
	if(0 < preg_match("/^(.*):(.*)\((....)\)$/", $titleStr, $matches))
	{
		$lwVars["pagetype"] = "album";
		$lwVars["pagetemplate"] = "Album";
		$lwVars["artist"] = trim($matches[1]);
		$artist = $lwVars["artist"];
		if( 0 < preg_match("/^(.*?)\((.*?)\)$/",$lwVars["artist"],$m2) )
		{
			$lwVars["nativeartist"] = trim($m2[1]);
			$lwVars["romanartist"] = trim($m2[2]);
		}
		else
		{
			$lwVars["romanartist"] = $lwVars["nativeartist"] = $lwVars["artist"];
		}
		$lwVars["album"] = trim($matches[2]);
		$lwVars["albumyear"] = trim($matches[3]);
		$lwVars["artistfletter"] = findFirstLetterOf($lwVars["artist"]);
		$lwVars["albumfletter"] = findFirstLetterOf($lwVars["album"]);
	}
	else if(0 < preg_match("/^(.*):(.*?)$/", $titleStr, $matches))
	{
		$lwVars["pagetype"] = "song";
		$lwVars["pagetemplate"] = "Song";
		$lwVars["artist"] = trim($matches[1]);
		if( 0 < preg_match("/^(.*?)\((.*?)\)$/",$lwVars["artist"],$m2) )
		{
			$lwVars["nativeartist"] = trim($m2[1]);
			$lwVars["romanartist"] = trim($m2[2]);
		}
		else
		{
			$lwVars["romanartist"] = $lwVars["nativeartist"] = $lwVars["artist"];
		}
		$lwVars["song"] = trim($matches[2]);
		$song = $lwVars["song"];
		$lwVars["artistfletter"] = findFirstLetterOf($lwVars["artist"]);
		$lwVars["songfletter"] = findFirstLetterOf($lwVars["song"]);
	}
	else
	{
		$lwVars["pagetype"] = "artist";
		$lwVars["pagetemplate"] = "Artist";
		$lwVars["artist"] = trim($titleStr);
		if( 0 < preg_match("/^(.*?)\((.*?)\)$/",$lwVars["artist"],$m2) )
		{
			$lwVars["nativeartist"] = trim($m2[1]);
			$lwVars["romanartist"] = trim($m2[2]);
		}
		else
		{
			$lwVars["romanartist"] = $lwVars["nativeartist"] = $lwVars["artist"];
		}
		$lwVars["artistfletter"] = findFirstLetterOf($lwVars["artist"]);
	}
	if($isTalk){
		$lwVars["pagetype"] = "talk";
	}

	# calculate sort name
	$lwVars["artistsortname"] = trim(preg_replace("/^the/i","",$lwVars["artist"]));
}

function getLyricWikiVariables()
{
	global $lwVars;
	if( $lwVars )
	{
		return $lwVars;
	};

	global $wgTitle;
	$titleStr = $wgTitle->getFullText();
	$lwVars = LyricWikiVariableDefaults();

	$ns = $wgTitle->getNamespace();
	if(($ns != NS_MAIN) && ($ns  != NS_TALK))
	{
		//pages outside of the main namespace & talk shouldn't have music-related templates.
		$lwVars["pagetype"] = "none";
	}
	else
	{
		parseLyricWikiTitle( $titleStr, $lwVars );
	}

	return $lwVars;
}
 
$wgHooks['LanguageGetMagic'][] = 'wfLyricWikiMagicWords';
function wfLyricWikiMagicWords(&$aWikiWords, $langID)
{
	$lwVars = LyricWikiVariableDefaults();
	foreach($lwVars as $key=>$value)
	{
		$aWikiWords["MAG_LYRICWIKI_".$key] = array(0,strtoupper($key));
	}
	$aWikiWords["sterilizeTitle"] = array(0, "sterilizeTitle"); // this is a parser function, not a variable so we set it up separately - SWC 20080926
	return true;
}
 
#---------------------------------------------------
# Step 3: assign a value to our variable
#---------------------------------------------------
 
$wgHooks['ParserGetVariableValueSwitch'][] = 'wfLyricWikiVariableSwitch';
function wfLyricWikiVariableSwitch(&$parser, &$cache, &$magicWordId, &$ret)
{
	$lwVars = getLyricWikiVariables();

	foreach( $lwVars as $key=>$value)
	{
		if( $magicWordId == "MAG_LYRICWIKI_".$key )
		{
			$ret = $value;
		}
	}
	return true;
}
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'LyricMagic',
	'version' => '0.1'
	);
 
$wgHooks['MagicWordwgVariableIDs'][] = 'wfLyricWikiDeclareVarIds';
function wfLyricWikiDeclareVarIds(&$magicWordIds)
{
	$lwVars = LyricWikiVariableDefaults();
	foreach($lwVars as $key=>$value)
	{
		$magicWordIds[] = "MAG_LYRICWIKI_".$key;
	}
	return true;
}

function wfLyricWikiSterilizeTitle( &$parser, $title = '' )
{
	$lwVars = Array();

	preg_match("/(.*?):(.*)/",$title,$match);
	$artist = $match[1];
	$song = $match[2];

	$artist = str_replace(
		array("&#39;","&amp;"),
		array("'","&"),
		urldecode($artist)
		);
	$song = str_replace(
		array("&#39;","&amp;"),
		array("'","&"),
		urldecode($song)
		);
	
	require_once 'Special_SOAP.methods.php';
	$res = sterilizeParameters($artist,$song);
	return $res[0].":".$res[1];
}

$wgExtensionFunctions[] = 'wfLyricWikiParserFunctions';
$wgHooks['custom_SandboxParse'][] = 'wfSterilizeParse';
function wfSterilizeParse( &$text )
{
	preg_match_all("/\{\{#sterilizeTitle:(.*?)\}\}/",$text,$matches,PREG_SET_ORDER );
	//echo count($matches);
	foreach( $matches as $match )
	{
		$dummy = null;
		$res = wfLyricWikiSterilizeTitle($dummy,$match[1]);
		$text = str_replace($match[0],$res,$text);
	}

	return true;
}

function wfLyricWikiParserFunctions()
{
	global $wgParser;

	$wgParser->setFunctionHook( 'sterilizeTitle', 'wfLyricWikiSterilizeTitle' );
}
?>
