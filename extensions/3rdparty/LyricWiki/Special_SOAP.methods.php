<?php

// NOTE: This doesn't appear to be included anywhere.  Is it used, or planned to be used? - SWC 20110101

// require_once 'Special_SOAP.getSong.php';
// require_once 'Special_SOAP.getSOTD.php';

function sterilizeParameters($artist, $song, $doHyphens=true)
{
	// sterilize parameters
	$lastHyphen = false; // if this isn't false and there is no result, then the whole thing will be tried again using hyphenSong as the song.
	if($doHyphens)
	{
		// can be turned off so that a second pass can be made without this hyphen trick if it doesn't work the first time.
		$song = str_replace("_", " ", $song); // just so that we can use one strrpos on just one format
		$HYPHEN_DELIM = " - ";
		$lastHyphen = strrpos($song, $HYPHEN_DELIM);
		if($lastHyphen !== false)
		{
			$hyphenSong = $song; // in case there are no responses, this will be fed back into the same function but with this hyphen trick turned off
			$song = substr($song, $lastHyphen+strlen($HYPHEN_DELIM));
		}
	}

	// Wiki technical-restrictions.  See: http://www.lyricwiki.org/LyricWiki:Page_names#Technical_Restrictions
	$transArray = array(
		"<" => "Less Than", // < is not a valid character in wiki titles.
		"#" => "Number ", // note the trailing space
		"+" => "Plus",
	);
	$song = strtr($song, $transArray);
	$artist = strtr($artist, $transArray);
	if(strpos($song, "[") !== false)
	{
		$song = preg_replace("/\s*\[.*/i", "", $song);
	}
	if(strpos($artist, "[") !== false)
	{
		$artist = preg_replace("/\s*\[.*/i", "", $artist);
	}

	// Naming conventions. See: http://www.lyricwiki.org/LyricWiki:Page_names
	$transArray = array(
		"Aint" => "Ain't",
		"Dont" => "Don't",
		"Cant" => "Can't",
	); // common contractions.  Our standards USE the contractions.
	$song = strtr($song, $transArray);
	$artist = strtr($artist, $transArray);

	// Strip the "featuring" artists.
	$index = strpos(strtolower($artist), " ft.");
	$index = ($index===false?strpos(strtolower($artist), " feat."):$index);
	$index = ($index===false?strpos(strtolower($artist), "(feat."):$index);
	$index = ($index===false?strpos(strtolower($artist), " featuring"):$index);
	$index = ($index===false?strpos(strtolower($artist), "(featuring"):$index);
	$index = ($index===false?strpos(strtolower($artist), " ft "):$index);
	$index = ($index===false?strpos(strtolower($artist), "(ft"):$index);
	$index = ($index===false?strpos(strtolower($artist), "(aka"):$index);
	if($index !== false){
		$artist = substr($artist, 0, $index);
	}

	// Strip the "featuring" artists from the song title
	$index = strpos(strtolower($song), " ft.");
	$index = ($index===false?strpos(strtolower($song), " feat."):$index);
	$index = ($index===false?strpos(strtolower($song), "(feat."):$index);
	$index = ($index===false?strpos(strtolower($song), " featuring"):$index);
	$index = ($index===false?strpos(strtolower($song), "(featuring"):$index);
	$index = ($index===false?strpos(strtolower($song), " ft "):$index);
	$index = ($index===false?strpos(strtolower($song), "(ft"):$index);
	$index = ($index===false?strpos(strtolower($song), "(aka"):$index);
	if($index !== false){
		$song = substr($song, 0, $index);
	}

	# strip additional notations from the song title
	$song = str_replace(
		array("(Live)","(Remix)","(Radio Mix)"),
		"",
		$song
		);

	// Strip the "featuring" from song names - SWC 20070912
	$index = strpos(strtolower($song), " ft.");
	$index = ($index===false?strpos(strtolower($song), " feat."):$index);
	$index = ($index===false?strpos(strtolower($song), " featuring"):$index);
	$index = ($index===false?strpos(strtolower($song), " ft "):$index);
	if($index !== false){
		$song = substr($song, 0, $index);
	}

	return array($artist,$song);
}

////
// Returns the correctly formatted pagename from the artist and the song.
//
// If allowAllCaps is true, the ARTIST name will be kept as all-capitals if that is how it was passed in.
////
function lw_getTitle($artist, $song='', $applyUnicode=true, $allowAllCaps=true){
	if(!$allowAllCaps)
	{
		$artist = strtolower($artist); // if left as all caps, ucwords won't change it
	}
	if($song != '')
	{
		$title = urldecode(ucwords($artist).":".ucwords(strtolower($song)));
	}
	else
	{
		$title = urldecode(ucwords($artist));
	}
	if($applyUnicode)
	{
		$title = utf8_encode($title);
	}
	$title = str_replace("|", "/", $title); # TODO: Figure out if this is the right solution.
	$title = preg_replace('/([-\("\.\/:_])([a-z])/e', '"$1".strtoupper("$2")', $title);
	$title = preg_replace('/\b(O)[\']([a-z])/ei', '"$1".strtoupper("\'$2")', $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.  Does it to "O'Riley" but not "I'm" or "Don't"
	$title = preg_replace('/( \()[\']([a-z])/ei', '"$1".strtoupper("\'$2")', $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.
	$title = preg_replace('/ [\']([a-z])/ei', '" ".strtoupper("\'$1")', $title); // single-quotes like above, but this is needed to avoid escaping the single-quote here.
	$title = strtr($title, " ", "_"); // Warning: multiple-byte substitutions don't seem to work here, so smart-quotes can't be fixed in this line.
	return $title;
} // end lw_getTitle()

////
// Returns true if the string passed in is a well-formed UTF8 string.
//
// Function from:
// http://www.phpwact.org/php/i18n/charsets#checking_utf-8_for_well_formedness
////
function utf8_compliant($str){
    if(strlen($str) == 0){
        return TRUE;
    }
    // If even just the first character can be matched, when the /u
    // modifier is used, then it's valid UTF-8. If the UTF-8 is somehow
    // invalid, nothing at all will match, even if the string contains
    // some valid sequences
    return (preg_match('/^.{1}/us',$str,$ar) == 1);
} // end utf8_compliant(...)

