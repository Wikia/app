<?php
# Digg WikiMedia extension
# by Naoise Golden Santos (email)
# http://www.goldensantos.com/blog/?p=7

# Usage:
# <Digg title="" topic=""></Digg>

# To install it put this file in the extensions directory
# To activate the extension, include it from your LocalSettings.php
# with: require("extensions/YourExtensionName.php");

$wgHooks['ParserFirstCallInit'][] = "wfDigg";

function wfDigg( $parser ) {
    # registers the <Digg> extension with the WikiText parser
    $parser->setHook( "digg", "renderDigg" );
    return true;
}

$wgDiggSettings = array(
    'link'  => '',
    'title'  => '',
    'topic'  => ''
);

# The callback function for converting the input text to HTML output
function renderDigg( $input, $argv ) {
	global $wgDiggSettings;

	foreach (array_keys($argv) as $key) {
		$wgDiggSettings[$key] = $argv[$key];
	}

	$wgDiggSettings['link'] = str_replace('http://', '', $wgDiggSettings['link']) ;

	$output = '<script type="text/javascript">';
	if ($wgDiggSettings['link'] != "") {
		$output .= "digg_url = '" . $wgDiggSettings['link']. "';";
	}
	if ($wgDiggSettings['title'] != "") {
		$output .= "digg_title = '" . $wgDiggSettings['title'] . "';";
	}
	if ($wgDiggSettings['topic'] != "") {
		$output .= "digg_topic = '" . $wgDiggSettings['topic'] . "';";
	}

	$output .= '</script>';

	$output .= '<script src="&#104;ttp://digg.com/tools/diggthis.js" type="text/javascript"></script>';

    return $output;
}

$wgHooks['ParserFirstCallInit'][] = "wfSafeScript";

function wfSafeScript( $parser ) {
    # registers the <Digg> extension with the WikiText parser
    $parser->setHook( "SafeScript", "renderSafeScript" );
    return true;
}

$wgSafeScriptSettings = array(
    'domain'  => '',
    'path'  => ''
);

$safeDomains = array('embed.technorati.com');

function renderSafeScript( $input, $argv ) {
	$output = "NONE";
	try {
		global $wgSafeScriptSettings;
		global $safeDomains;

		foreach (array_keys($argv) as $key) {
			$wgSafeScriptSettings[$key] = $argv[$key];
		}

		if (in_array($wgSafeScriptSettings['domain'], $safeDomains)) {
			$output = '<script type="text/javascript" src="&#104;ttp://'.$wgSafeScriptSettings['domain'].'/'. $wgSafeScriptSettings['path'].'"></script>';
		}
	} catch (Exception $myException) {
		echo $myException->getMessage ();
	}
	return $output;
}

?>
