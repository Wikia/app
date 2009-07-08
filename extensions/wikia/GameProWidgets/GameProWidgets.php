<?php
/**
 * GamePro Widgets Extension - Displays GamePro widgets (see http://api.gamepro.com/widgets)
 *
 * @author Przemek Piotrowski (Nef) <ppiotr@wikia-inc.com>
 */

if (!defined("MEDIAWIKI")) {
	die("This file is an extension to the MediaWiki software and cannot be used standalone.");
}

$wgExtensionCredits["other"][] = array(
	"name"        => "GamePro widgets",
	"author"      => "[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]",
	"description" => "Displays GamePro widgets",
	"version"     => "1.0",
);

$wgExtensionFunctions[] = 'wfGameProWidgetsSetup';

function wfGameProWidgetsSetup() {
	global $wgParser;

	$wgParser->setHook("gpwidget", "wfGameProWidgetsEmbeed");
}

function wfGameProWidgetsParseUrl($input) {
	$id = $input;

	if (preg_match('/^([0-9a-f\/]+)$/', $input, $preg)) {
		$id = $preg[1];
	}
	elseif (preg_match('/^http:\/\/widgets.clearspring.com\/o\/([0-9a-f\/]+)$/', $input, $preg)) {
		$id = $preg[1];
	}

	preg_match('/([0-9a-f/]+)/', $id, $preg);
	$id = $preg[1];

	return $id;
}

function wfGameProWidgetsEmbeed($input, $argv, &$parser) {
	$wid    = null;

	$width  = 300; $width_max  = 450;
	$height = 270; $height_max = 405;

	if (!empty($argv["wid"])) {
		$wid = wfGameProWidgetsParseUrl($argv["wid"]);
	}
	elseif (!empty($input)) {
		$wid = wfGameProWidgetsParseUrl($input);
	}

	if (!empty($argv["width"]) && settype($argv["width"], "integer") && ($width_max >= $argv["width"])) {
		$width = $argv["width"];
	}
	if (!empty($argv["height"]) && settype($argv["height"], "integer") && ($height_max >= $argv["height"])) {
		$height = $argv["height"];
	}

	if (!empty($wid)) {
		$url = "http://widgets.clearspring.com/o/{$wid}";
		$id  = "W" . substr(str_replace("/", "", $wid), 0, 32);

		return "<object type=\"application/x-shockwave-flash\" data=\"{$url}\" id=\"{$id}\" width=\"{$width}\" height=\"{$height}\"><param name=\"movie\" value=\"{$url}\" /><param name=\"wmode\" value=\"transparent\" /><param name=\"allowNetworking\" value=\"all\" /><param name=\"allowScriptAccess\" value=\"always\" /></object>";
	}
}
