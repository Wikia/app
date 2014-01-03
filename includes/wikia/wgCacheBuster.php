<?php
/**
 * This file contains just the wgCacheBuster so that it can be included from
 * various code-paths, some of which don't load the rest of the MediaWiki stack.
 */

global $wgDevelEnvironment;
if ($wgDevelEnvironment) {
	global $wgCacheBuster;
	$wgCacheBuster = time();
} else {
	$cbFilePath = "$IP/wgCacheBuster.php";
	include_once($cbFilePath);
}
