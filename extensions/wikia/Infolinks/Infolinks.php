<?php
/**
 * Infolinks Extension - Displays ad code that creates double-underline text links
 *
 * @author Przemek Piotrowski (Nef) <ppiotr@wikia-inc.com>
 */

if (!defined("MEDIAWIKI")) {
	die("This file is an extension to the MediaWiki software and cannot be used standalone.");
}

$wgExtensionCredits["other"][] = array(
	"name"        => "Infolinks",
	"author"      => "[http://www.wikia.com/wiki/User:Ppiotr Przemek Piotrowski (Nef)]",
	"description" => "Displays ad code that creates double-underline text links",
	"version"     =>  1.0,
);

$wgExtensionFunctions[] = 'wfInfolinksSetup';

function wfInfolinksSetup() {
	global $wgHooks;
	global $wgInfolinksAccess, $wgUser;

	if (!empty($wgInfolinksAccess)) {
		if (!in_array("User:{$wgUser->getName()}", $wgInfolinksAccess) && !count(array_intersect($wgUser->getGroups(), $wgInfolinksAccess))) {
			return;
		}
	}

	$wgHooks["OutputPageBeforeHTML"][] = "wfInfolinksHook";
}

function wfInfolinksHook(&$out, &$text) {
	global $wgOut;

	$wgOut->addHtml("<script type=\"text/javascript\">var infolink_pid = 26475;</script>");
	$wgOut->addHtml("<script type=\"text/javascript\" src=\"http://resources.infolinks.com/js/infolinks_main.js\"></script>");

	return true;
}
