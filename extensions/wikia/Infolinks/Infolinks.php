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
	"svn-date"    => '$LastChangedDate$',
	"svn-revision" => '$LastChangedRevision$',
);

$wgExtensionFunctions[] = 'wfInfolinksSetup';

function wfInfolinksSetup() {
	global $wgHooks;

	$wgHooks["SkinAfterBottomScripts"][] = "wfInfolinksHook";
}

function wfInfolinksHook(&$skin, &$text) {
	global $wgUser;

	if ($wgUser->isAnon() && ArticleAdLogic::isContentPage()) {
		$text .= "<script type=\"text/javascript\">var infolink_pid = 26475;</script>\n";
		$text .= "<script type=\"text/javascript\" src=\"http://resources.infolinks.com/js/infolinks_main.js\"></script>\n";
	}

	return true;
}
