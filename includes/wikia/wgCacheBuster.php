<?php
/**
 * This file contains just the wgCacheBuster so that it can be included from
 * various code-paths, some of which don't load the rest of the MediaWiki stack.
 */

global $wgMedusaSlot, $wgDevelEnvironment;

$slot_name = 'code' . ($wgMedusaSlot == 1 ? '' : $wgMedusaSlot);
$cbFilePath = "/usr/wikia/deploy/$slot_name/src/wgCacheBuster.php";

if ($wgDevelEnvironment) {
	global $wgCacheBuster;
	$wgCacheBuster = time();
} else {
	include_once($cbFilePath);
}
