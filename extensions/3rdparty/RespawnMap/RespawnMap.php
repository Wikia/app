<?php
# MediaWiki Respawn Map extension
#
# Example:
# <respawnmap itemsize="16" image="Goroma1.jpg">
# Troll=310px,50px|3 Trolls
# Fire Elemental=330px,75px|1 or 2 FEs
# Fire Elemental=120px,325px|Lots of FEs
# </respawnmap>
#
# (C) Copyright 2007, Patrick Delancy. All rights reserved.
# Free for personal and commercial uses, including derived works, as long as this notice is retained unaltered.

$wgExtensionFunctions[] = "wfRespawnMapExtension";
$wgExtensionCredits['respawnmap'][] = array(
	'name' => 'Tavin Respawn Map',
	'author' =>'Patrick Delancy',
	'url' => 'http://tibia.erig.net/User:Whitelaces',
	'description' => 'Displays a simple div with background image and explicitly placed smaller images to represent a respawn map of creatures or items.'
);

$wgHooks['LanguageGetMagic'][] = 'wfImageURL_Magic';

function wfRespawnMapExtension() {
	global $wgParser, $wgMessageCache;
	# register the extension with the WikiText parser
	# the first parameter is the name of the new tag.
	# the second parameter is the callback function for
	# processing the text between the tags
	$wgParser->setHook( "respawnmap", "renderRespawnMap" );
	$wgParser->setFunctionHook( "imageurl", "imageURL" );

	#add translatable text strings to the message cache
	$wgMessageCache->addMessage('respawn:noexist', 'The file "$1" does not exist.');
}

# The callback function for converting the input text to HTML output
function renderRespawnMap( $input, $argv, &$parser ) {

	// quick hack to get rid of 'undefined index' notices...
	foreach (array('image', 'itemwidth', 'itemheight') as $a)
	{
		if (!isset($argv[$a])) $argv[$a] = '';
	}

	$localParser = new Parser();

	$imageObj = Image::newFromName( $argv['image'] );
	if (!$imageObj || !$imageObj->exists())
		return wfMsg('respawn:noexist', $argv['image']);

	$output = "<div style=\"width: " . $imageObj->getWidth() . "px; height: " . $imageObj->getHeight() . "px; margin: 0; padding: 0; background: url('" . $imageObj->getViewURL() . "')\">";

	$lines = explode( "\n", $input );

	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( $line == '' || $line[0] == '#' ) {
			continue;
		}

		$itemName = '';
		$parms = '0,0|';
		$pos = '0,0';
		$details = '';
		$posX = 0;
		$posY = 0;

		list($itemName, $parms) = explode('=', $line, 2);
		list($pos, $details) = explode('|', $parms, 2);
		list($posX, $posY) = explode(',', $pos, 2);

		$imageObj = Image::newFromName( $itemName . ".gif" );
		if (!$imageObj || !$imageObj->exists())
			continue;

		$outputObj = $localParser->parse(trim($details), $parser->mTitle, $parser->mOptions);
		$details = trim(str_replace('<p>', '', str_replace('</p>', '', $outputObj->getText())));

		$output .= "<div style=\"position: relative; " . ($argv['itemheight'] != "" ? "width: " . $argv['itemwidth'] . "; height: " . $argv['itemheight'] . ";" : "") . "left: " . $posX . "; top: " . $posY . ";\">";
		$output .= "<img src=\"" . $imageObj->getViewURL() . "\" alt=\"" . htmlentities($details) . "\" title=\"" . htmlentities($details) . "\"" . ($argv['itemheight'] != "" ? " height=\"" . $argv['itemheight'] . "\"" : " ") . "/>";
		$output .= "</div>";
	}

	$output .= "</div>";

	return $output;
}

function wfImageURL_Magic( &$magicWords, $langCode ) {
	$magicWords['imageurl'] = array( 0, 'imageurl' );
	return true;
}

function imageURL(&$parser, $name = '') {

	$imageObj = Image::newFromName( $name );
	if (!$imageObj || !$imageObj->exists())
		return wfMsg('respawn:noexist', $name);
	else
		return $imageObj->getViewURL();

}
?>
