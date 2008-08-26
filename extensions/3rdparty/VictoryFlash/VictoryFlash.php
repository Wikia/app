<?php
/**
* VictoryFlash parser extension - adds <victoryflash> tag
* for embedding content from VictoryFlash.net
*
* @author Jack Phoenix <wikia.jack@gmail.com>
* @copyright ? 2008 Jack Phoenix
*/
if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$wgExtensionFunctions[] = 'wfVictoryFlash';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'VictoryFlash',
	'version' => '1.0',
	'description' => 'Embeds VictoryFlash SWF applets with <tt>&lt;victoryflash&gt;</tt> tag',
	'author' => 'Jack Phoenix',
	'url' => 'http://help.wikia.com/wiki/VictoryFlash'
);

function wfVictoryFlash() {
	global $wgParser;
	$wgParser->setHook('victoryflash', 'renderVictoryFlash');
}

# The callback function for converting the input text to HTML output
function renderVictoryFlash($input, $argv) {

	$width  = isset($argv['width']) ? $argv['width']  : 424;
	$height = isset($argv['height'])? $argv['height'] : 76;
	$desc   = isset($argv['desc'])? $argv['desc'] : test;
	$gs     = isset($argv['gs'])? $argv['gs'] : 5;

	$output = '<embed width="'.htmlspecialchars($width).'" height="'.htmlspecialchars($height).'" src="http://www.victoryflash.net/swf/achievementanimation2.swf"'
	.' wmode="transparent" FlashVars="d='.htmlspecialchars($desc).'&gs='.htmlspecialchars($gs).'"></embed>';

	return $output;
}
