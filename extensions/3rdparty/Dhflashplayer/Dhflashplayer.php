<?php
// DreamHost's free flash media player Mediawiki extension
// from http://cosmochips.net/
//
// DreamHost free flash media player wiki page :
// http://wiki.dreamhost.com/index.php?title=Flash_Media_Player
//
// Derivated from FlashOnWeb-Stream Mediawiki extension by Eric Larcher 23.09.2006
// http://www.mediawiki.org/wiki/Extension:Flashow
//
// Installation:
//  * save the code as dhflashplayer.php into the extension directory of your mediawiki installation
//  * add the following to the end of LocalSettings.php: include("extensions/dhflashplayer.php");
//  * a zip file of the code is also available here :
//  http://cosmochips.net/resources/scripts/mediawiki_extension_dhflashplayer.zip
//
// Usage:
//  Use one section between <dhflashplayer>-tags for each feed. The dhflashplayer section may contain parameters
//  separated by a pipe ("|"), just like links and templates. These parameters should be supported:
//
//	* file			=	file name with extension (e.g. "snake.swf")
//	* width			=	width of the movie in px (e.g. "150")
//	* height		=	height of the movie in px (e.g. "80")
//	* path			=	full path of the movie file (e.g. "http://badger.com/")
//	* charset		=	charset used by the feed (e.g. "utf-8")
//
// Example:
//	<dhflashplayer>file=mushroom.flv|width=200|height=120|path=http://cosmochips.net/resources/movies/</dhflashplayer>
//

//install extension hook
$wgExtensionFunctions[] = "wfDhflashplayerExtension";
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'dhflashplayer',
	'author' => 'PatrikRoy',
	'url' => 'http://cosmochips.net/mediawiki/index.php?title=Script:Dhflashplayer.php',
	'description' => 'allows insertion of a flash objet in mediawiki page for DreamHost hosting',
);

//extension hook callback function
function wfDhflashplayerExtension() {
	global $wgParser;
	//install parser hook for <dhflashplayer> tags
	$wgParser->setHook( "dhflashplayer", "renderDhflashplayer" );
}

//parser hook callback function
function renderDhflashplayer($input, $argv, $parser = null) {
	if (!$parser) $parser =& $GLOBALS['wgParser'];
	global $wgOutputEncoding;
	$DefaultEncoding = "ISO-8859-1";

	if (!$input) return ""; //if <dhflashplayer>-section is empty, return nothing

	//parse fields in dhflashplayer-section
	$fields= explode("|",$input);

	$args= array();
	for ($i=0; $i<sizeof($fields); $i++) {
		$f= $fields[$i];
		if (strpos($f,"=")===False) $args[strtolower(trim($f))]= False;
		else {
			list($k,$v)= explode("=",$f,2);
			if (trim($v)==False) $args[strtolower(trim($k))] = False;
			else $args[strtolower(trim($k))]= trim($v);
		}
	}

	//get charset from argument-array
	$charset= @$args["charset"];
	if (!$charset) $charset= $DefaultEncoding;

	//get parameters from argument-array
	//(if you need an extra parameter, add it here and in the Final Output code)
	$file = @$args["file"];
	$width = @$args["width"];
	$height = @$args["height"] + 20; //adding player's toolbar height
	$path = @$args["path"];

	// Final Output
	return "
<script type=\"text/javascript\" src=\"https://media.dreamhost.com/ufo.js\"></script>
<p id=\"".$file."\"><a href=\"http://www.macromedia.com/go/getflashplayer\">Get the Flash Player</a> to see this player.</p>
<script type=\"text/javascript\"> var FO = { movie:\"https://media.dreamhost.com/mediaplayer.swf\",width:\"".$width."\",height:\"".$height."\",majorversion:\"7\",build:\"0\",bgcolor:\"#fff\", flashvars:\"file=".$path.$file."\" };
UFO.create(FO,\"".$file."\");
</script>
	";
}
?>