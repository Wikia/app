<?php
# MapLib Tags
#
# Tag:
#   <maplib>map</maplib>

# Enjoy!

$wgExtensionFunctions[] = 'callmaplib';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'MapLib',
	'description' => 'Display MapLib iframe',
	'author' => 'Ralstlin',
	'url' => 'http://help.wikia.com/wiki/MapLib'
);

function callmaplib() {
	global $wgParser;
	$wgParser->setHook('MapLib', 'renderMaplib');
}

# The callback function for converting the input text to HTML output
function renderMaplib($input, $params) {

	$output = '';

	if (preg_match('/^[0-9]{1,}$/', $input) && preg_match('/^[0-9]{1,}$/',$params['width']) && preg_match('/^[0-9]{1,}$/', $params['height']))
	{

		$width = (string) $params['width']."px";
		$height = (string) $params['height']."px";
		$output="<iframe src=\"http://www.maplib.net/fullmap.php?id={$input}\" scrolling=\"no\" frameborder=\"0\" style=\"width: {$width}; height: {$height}; border: 0px;\"></iframe>";
	}

	return $output;
}
