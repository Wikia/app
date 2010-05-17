<?php
# Badge WikiMedia extension
# by Naoise Golden Santos (email)
# http://www.goldensantos.com/blog/?p=7

# Usage:
# <Badge symbol=""></Badge>

# To install it put this file in the extensions directory 
# To activate the extension, include it from your LocalSettings.php
# with: require("extensions/YourExtensionName.php");

$wgExtensionFunctions[] = "wfBadge";

// Set up entry point as special page
$wgAutoloadClasses['BadgeImage'] = dirname( __FILE__ ) . '/badgeImage.body.php';
$wgSpecialPages['BadgeImage'] = 'BadgeImage';

function wfBadge() {
    global $wgParser;
    # registers the <Badge> extension with the WikiText parser
    $wgParser->setHook( "Badge", "renderBadge" );
}

$wgBadgeSettings = array('symbol'  => '');

# The callback function for converting the input text to HTML output
function renderBadge( $input, $argv ) {
	global $wgBadgeSettings;
	
	foreach (array_keys($argv) as $key) {
		$wgBadgeSettings[$key] = $argv[$key];
	}
	$symbol = $wgBadgeSettings['symbol'];

	$title = "Click here to place this ticker in your message board signature, on your website, or on your MySpace profile";
	$output = "<script language=\"javascript\">";
	$output .= "var symbol = \"{$symbol}\";";
	$output .= "symbol = symbol.replace(':', 'colon');";
	$output .= "symbol = symbol.replace('.', 'dot');";
	$output .= "var url = '&#104;ttp://techteam-qa3.wikia.com/wiki/Special:BadgeImage/' + symbol;";
	$output .= "document.write('<div id=\"badgeDiv\" style=\"float:left;\"><a href=\"javascript: badgeCode();\">');";
	$output .= "document.write('<img src=\"'+url+'\" alt=\"$title\" title=\"$title\" width=160 height=32 border=\"0\"></a><br>');";
	$output .= "document.write('<div class=\"badgeCodeText\" style=\"float:left;\"><a href=\"javascript: badgeCode();\">$title</a></div></div>');";
	$output .= "document.write('<div id=\"badgeCodeDiv\">');";
	$output .= "document.write('Copy this code and paste it into your message board signature box,<br>your website, or your MySpace profile.<br>');";
	$output .= "document.write('<textarea name=\"badgeCodeArea\" style=\"overflow: hidden; width:90%; height: 60px;\" onFocus=\"javascript: this.select();\">');";
	$output .= "document.write('<a href=\"&#104;ttp://valuewiki.wikia.com/wiki/$symbol\">');";
	$output .= "document.write('<img src=\"'+url+'\" border=\"0\"></a></textarea><br>');";
	$output .= "document.write('<a href=\"javascript: badgeCode();\">Close</a>');";
	$output .= "document.write('</div>');";
	
	$output .= "function badgeCode() {";
	$output .= "	temp = document.getElementById('badgeCodeDiv');";
	$output .= "	if (temp.style.visibility == 'visible') {";
	$output .= "		temp.style.visibility = 'hidden';";
	$output .= "	} else {";
	$output .= "		temp.style.visibility = 'visible';";
	$output .= "	}";
	$output .= "}";

	$output .= "</script>";
	
	return $output;
}
